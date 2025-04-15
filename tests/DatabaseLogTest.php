<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use LeonardoHipolito\LaravelLogDb\Logging\DatabaseLogger;
use LeonardoHipolito\LaravelLogDb\Support\DatabaseDateIntervalNameResolver;

uses(RefreshDatabase::class);

beforeEach(function () {
    config()->set('logging.channels.db', [
        'driver' => 'custom',
        'via' => DatabaseLogger::class,
        'name'=>fn()=>DatabaseDateIntervalNameResolver::make()->daily(),
    ]);
    config()->set('logging.channels.db.connection', 'sqlite');
});

it('logs to the database', function () {
    Log::channel('db')->info('Test message');
    expect(config('database.connections.sqlite.database'))
        ->toBe(database_path(DatabaseDateIntervalNameResolver::make()->daily()));
    $this->assertDatabaseHas('laravel_logs', [
        'level_name' => mb_strtoupper('info'),
        'message' => 'Test message',
    ],config('logging.channels.db.connection'));
});
