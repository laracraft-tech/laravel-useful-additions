<?php

namespace LaracraftTech\LaravelUsefulAdditions\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DBTruncateCommand extends Command
{
    use ConfirmableTrait;

    protected $signature = 'db:truncate {tables?* : Optionally specify only specific tables to truncate}
               {--force : Force the operation to run when in production}
               {--checks=true : Enable or disable foreign key checks during truncation}';

    protected $description = 'Truncate all tables';

    public function handle(): int
    {
        if (! $this->confirmToProceed()) {
            return 1;
        }

        $foreignKeyChecks = $this->hasOption('checks') && filter_var($this->option('checks'), FILTER_VALIDATE_BOOLEAN);

        if (! $foreignKeyChecks) {
            $this->components->warn('Disabling foreign key checks!');
            Schema::disableForeignKeyConstraints();
        }

        $this->components->info('Start truncating tables.');

        $tables = $this->argument('tables') ?: collect(Schema::getAllTables())->map(function ($tableDefinition) {
            return current($tableDefinition);
        });

        collect($tables)->each(function ($table) {
            $this->components->task("Truncating table: $table", function () use ($table) {
                DB::table($table)->truncate();
            });
        });

        $this->newLine();

        $this->components->info('Finished truncating tables.');

        if (! $foreignKeyChecks) {
            $this->components->warn('Re-enabling foreign key checks!');
            Schema::enableForeignKeyConstraints();
        }

        return self::SUCCESS;
    }
}
