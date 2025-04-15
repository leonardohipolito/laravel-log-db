<?php

namespace LeonardoHipolito\LaravelLogDb\Handler;

use Closure;
use Exception;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use LeonardoHipolito\LaravelLogDb\Models\LaravelLog;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;
use Monolog\LogRecord;
use SQLite3;
use Throwable;

class DatabaseHandler extends AbstractProcessingHandler
{
    public function __construct(Closure|null $name = null)
    {
        $database = value($name);
        if($database){
            config()->set('database.connections.sqlite.database', database_path($database));
        }
    }
    protected function write(LogRecord $record): void
    {
        $this->createDatabase();
        $record = is_array($record) ? $record : $record->toArray();

        if ($this->hasMinimumLevelSet() && !$this->meetsMinimumLevelThreshold($record['level'])) {
            return;
        }

        $exception = $record['context']['exception'] ?? null;

        if ($exception instanceof Throwable) {
            $record['context']['exception'] = (string)$exception;
        }
        try {
            LaravelLog::create([
                'level' => $record['level'],
                'level_name' => $record['level_name'],
                'message' => $record['message'],
                'logged_at' => $record['datetime'],
                'context' => $record['context'],
                'extra' => $record['extra'],
            ]);
        } catch (Exception $e) {
            $fallbackChannels = config('logging.channels.fallback.channels', ['single']);

            Log::stack($fallbackChannels)->debug($record['formatted'] ?? $record['message']);

            Log::stack($fallbackChannels)->debug('Could not log to the database.', [
                'exception' => $e,
            ]);
        }
    }

    protected function createDatabase(): void
    {
        if (!file_exists(config('database.connections.sqlite.database'))) {
            $db = new SQLite3(config('database.connections.sqlite.database'));
            $db->exec("CREATE TABLE IF NOT EXISTS laravel_logs (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                level_name TEXT,
                level INTEGER,
                message TEXT,
                logged_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                context TEXT,
                extra TEXT
            )");
            $db->close();
        }
    }

    public function hasMinimumLevelSet()
    {
        return config('logging.channels.db.level') !== null;
    }

    public function meetsMinimumLevelThreshold(int $currentLevel): bool
    {
        $minimumLevel = Logger::toMonologLevel(config('logging.channels.db.level'));

        if (!is_int($minimumLevel)) {
            $minimumLevel = $minimumLevel->value;
        }

        return $currentLevel >= $minimumLevel;
    }
}
