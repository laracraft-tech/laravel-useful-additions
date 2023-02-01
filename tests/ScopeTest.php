<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use LaracraftTech\LaravelUsefulTraits\UsefulScopes;

beforeEach(function () {
    Schema::create('scope_test_table', function (Blueprint $blueprint) {
        $blueprint->string('foo');
        $blueprint->string('bar');
        $blueprint->string('quz');
    });

    DB::table('scope_test_table')->insert([
        'foo' => 'foo',
        'bar' => 'bar',
        'quz' => 'quz',
    ]);
});

it('can query with exclude', function () {
    $class = new class extends Model
    {
        use UsefulScopes;

        protected $table = 'scope_test_table';
    };

    expect($class::query()->selectAllBut(['foo'])->first()->toArray())->toBe([
        'bar' => 'bar',
        'quz' => 'quz',
    ]);
});
