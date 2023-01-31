<?php

namespace LaracraftTech\LaravelUsefulTraits\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use InvalidArgumentException;

trait ScopeSelectAllBut
{
    /**
     * Scope a query to only exclude specific Columns.
     *
     * @param Builder $query
     * @param $columns
     * @return Builder
     */
    public function scopeSelectAllBut($query, $columns): \Illuminate\Database\Eloquent\Builder
    {
        $tableColumns = $this->getTableColumns();

        if ($columns == $tableColumns) {
            throw new InvalidArgumentException('You can not exclude all columns!');
        }

        return $query->select(array_diff($tableColumns, $columns));
    }


    /**
     * Shows All the columns of the Corresponding Table of Model
     *
     * If You need to get all the Columns of the Model Table.
     * Useful while including the columns in search.
     * NOTE: COLUMN NAMES OF TABLE WILL BE CACHED UNTIL CONTENTS OF MIGRATIONS DIRECTORY IS ADDED OR DELETED.
     * MODIFYING THE CONTENTS OF FILES INSIDE THE MIGRATIONS DIRECTORY WILL NOT RE-CACHE THE COLUMNS
     * Whenever you make a new deployment/migration you can clear the cache.
     * @return array
     **/
    public function getTableColumns(): array
    {
        $cacheKey = 'MigrMod:'.filemtime(database_path('migrations')).':'.$this->getTable();

        return Cache::rememberForever($cacheKey, function () {
            return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
        });
    }
}
