<?php

namespace LeonardoHipolito\LaravelLogDb\Logging;

use LeonardoHipolito\LaravelLogDb\Handler\DatabaseHandler;
use Monolog\Logger;

class DatabaseLogger{
    public function __invoke(array $config): Logger
    {
        return new Logger(
            'DatabaseLogger',
            [
                new DatabaseHandler(name:data_get($config,'name')),
            ]
        );
    }
}
