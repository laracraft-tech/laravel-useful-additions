<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use LaracraftTech\LaravelUsefulTraits\RefreshDatabaseFast;
use LaracraftTech\LaravelUsefulTraits\Tests\TestCase;

uses(RefreshDatabaseFast::class);

uses(TestCase::class)->in(__DIR__);
