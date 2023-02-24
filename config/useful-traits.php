<?php

return [
    "refresh_db_fast" => [
        /**
         * This field determines if the database should be seeded after migration.
         */
        "seed" => env('USEFUL_TRAITS_SEED_AFTER_FAST_DB_REFRESH', false),
    ],
];
