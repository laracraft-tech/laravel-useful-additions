<?php

namespace LaracraftTech\LaravelUsefulAdditions\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulScopes;

class ScopeTest extends Model
{
    use UsefulScopes;

    protected $guarded = false;
}
