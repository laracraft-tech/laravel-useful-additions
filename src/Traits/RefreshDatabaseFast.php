<?php

namespace LaracraftTech\LaravelUsefulAdditions\Traits;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\RefreshDatabaseState;
use Symfony\Component\Finder\Finder;

/**
 * Only migrate fresh if necessary -> much faster after first time!
 * Credits to mayahi, with some small changes of mine.
 *
 * @link https://mayahi.net/laravel/make-refresh-database-trait-much-faster/
 */
trait RefreshDatabaseFast
{
    use RefreshDatabase;

    /**
     * Only migrates fresh if necessary
     */
    protected function refreshTestDatabase(): void
    {
        if (! RefreshDatabaseState::$migrated) {
            $this->runMigrationsIfNecessary();

            $this->app[Kernel::class]->setArtisan(null);

            RefreshDatabaseState::$migrated = true;
        }

        $this->beginDatabaseTransaction();
    }

    /**
     * Check if migration fresh is necessary by checking
     * if the migrations files checksum has changed.
     */
    protected function runMigrationsIfNecessary(): void
    {
        if (! $this->identicalChecksum()) {
            if (config('useful-additions.refresh_db_fast.seed')) {
                $this->seed();
            }

            $this->artisan('migrate:fresh', $this->migrateFreshUsing());

            //create checksum after migration finishes
            $this->createChecksum();
        }
    }

    /**
     * Calaculates the checksum of the migration files.
     */
    private function calculateChecksum(): string
    {
        $files = Finder::create()
            ->files()
            ->exclude([
                'factories',
                'seeders',
            ])
            ->in(database_path())
            ->ignoreDotFiles(true)
            ->ignoreVCS(true)
            ->getIterator();

        $files = array_keys(iterator_to_array($files));

        $checksum = collect($files)->map(function ($file) {
            return md5_file($file);
        })->implode('');

        return md5($checksum);
    }

    /**
     * Filepath to store the checksum.
     */
    private function checksumFilePath(): string
    {
        return base_path('.phpunit.database.checksum');
    }

    /**
     * Creates the checksum file.
     */
    private function createChecksum(): void
    {
        file_put_contents($this->checksumFilePath(), $this->calculateChecksum());
    }

    /**
     * Get the checksum file content.
     *
     * @return false|string
     */
    private function checksumFileContents()
    {
        return file_get_contents($this->checksumFilePath());
    }

    /**
     * Check if checksum exists.
     */
    private function isChecksumExists(): bool
    {
        return file_exists($this->checksumFilePath());
    }

    /**
     * Check if checksum of current database migration files
     * are identical to the one we stored already.
     */
    private function identicalChecksum(): bool
    {
        if (! $this->isChecksumExists()) {
            return false;
        }

        if ($this->checksumFileContents() === $this->calculateChecksum()) {
            return true;
        }

        return false;
    }
}
