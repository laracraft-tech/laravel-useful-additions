<?php

namespace LaracraftTech\LaravelUsefulAdditions\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use LaracraftTech\LaravelUsefulAdditions\UsefulScopes;

class ScopeTest extends Model
{
    use UsefulScopes;

    protected $guarded = false;
}
