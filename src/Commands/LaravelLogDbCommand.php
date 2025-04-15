<?php

namespace LeonardoHipolito\LaravelLogDb\Commands;

use Illuminate\Console\Command;

class LaravelLogDbCommand extends Command
{
    public $signature = 'laravel-log-db';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
