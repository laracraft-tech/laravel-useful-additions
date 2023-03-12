<?php

namespace LaracraftTech\LaravelUsefulAdditions\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DBTruncateCommand extends Command
{
    use ConfirmableTrait;

    public $signature = 'db:truncate';

    public $description = 'Truncate all tables';

    public function handle(): int
    {
        if (! $this->confirmToProceed()) {
            return 1;
        }

        $this->components->info('Preparing database.');

        collect(Schema::getAllTables())->each(function ($tableDefinition) {
            $table = current($tableDefinition);
            $this->components->task("Truncating table: $table", function () use ($table) {
                DB::table($table)->truncate();
            });
        });

        $this->newLine();

        return self::SUCCESS;
    }
}
