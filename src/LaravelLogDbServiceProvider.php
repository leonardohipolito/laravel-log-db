<?php

namespace LeonardoHipolito\LaravelLogDb;

use LeonardoHipolito\LaravelLogDb\Commands\LaravelLogDbCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelLogDbServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-log-db')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel_log_db_table')
            ->hasCommand(LaravelLogDbCommand::class);
    }
}
