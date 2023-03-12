<?php

namespace LaracraftTech\LaravelUsefulAdditions\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use LaracraftTech\LaravelUsefulAdditions\LaravelUsefulAdditionsServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'LaracraftTech\\LaravelUsefulAdditions\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelUsefulAdditionsServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_laravel-useful-additions_table.php.stub';
        $migration->up();
        */
    }
}
