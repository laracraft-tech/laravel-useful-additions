<?php

namespace LaracraftTech\LaravelUsefulAdditions;

use LaracraftTech\LaravelUsefulAdditions\Commands\DBTruncateCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelUsefulAdditionsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-useful-additions')
            ->hasConfigFile()
            ->hasCommand(DBTruncateCommand::class);
    }
}
