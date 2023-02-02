<?php

namespace LaracraftTech\LaravelUsefulTraits\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use LaracraftTech\LaravelUsefulTraits\UsefulScopes;

class ScopeTest extends Model
{
    use UsefulScopes;

    protected $guarded = false;
}
