<?php

namespace LaracraftTech\LaravelUsefulTraits;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use LaracraftTech\LaravelUsefulTraits\Commands\LaravelUsefulTraitsCommand;

class LaravelUsefulTraitsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-useful-traits');
    }
}
