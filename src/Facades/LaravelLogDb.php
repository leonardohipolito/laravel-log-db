<?php

namespace LeonardoHipolito\LaravelLogDb\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \LeonardoHipolito\LaravelLogDb\LaravelLogDb
 */
class LaravelLogDb extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \LeonardoHipolito\LaravelLogDb\LaravelLogDb::class;
    }
}
