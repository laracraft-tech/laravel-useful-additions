<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;
use LaracraftTech\LaravelUsefulTraits\Tests\Models\ScopeTest;

beforeEach(function () {
    Schema::create('scope_tests', function (Blueprint $blueprint) {
        $blueprint->string('foo');
        $blueprint->string('bar');
        $blueprint->string('quz');
        $blueprint->timestamps();
    });

    $class = new ScopeTest();
    $class->create(['foo' => 'foo1', 'bar' => 'bar1', 'quz' => 'quz1']);//auto sets created at to todoay (now)
    $class->create(['foo' => 'foo2', 'bar' => 'bar2', 'quz' => 'quz2']);//auto sets created at to todoay (now)
    $class->create(['foo' => 'foo3', 'bar' => 'bar3', 'quz' => 'quz3', 'created_at' => now()->yesterday()]);
    $class->create(['foo' => 'foo4', 'bar' => 'bar4', 'quz' => 'quz4', 'created_at' => now()->yesterday()]);
});

it('can query with exclude', function () {
    $class = new ScopeTest();

    $data = $class::query()->selectAllBut(['foo'])->get()->toArray();

    expect($data)->each->not->toHaveKey('foo');
});

it('can query only entries created today', function () {
    $class = new ScopeTest();

    //first make to array then back to collection, so that we can mutate the date
    $data = collect($class::query()->select()->fromToday()->get()->toArray());

    $data->transform(function ($item) {
        $item['created_at'] = Carbon::parse($item['created_at'])->toDateString();
        return $item;
    });

    expect($data->toArray())->each->toHaveKey('created_at', now()->toDateString());
});

it('can query only entries created yesterday', function () {
    $class = new ScopeTest();

    //first make to array then back to collection, so that we can mutate the date
    $data = collect($class::query()->select()->fromYesterday()->get()->toArray());

    $data->transform(function ($item) {
        $item['created_at'] = Carbon::parse($item['created_at'])->toDateString();
        return $item;
    });

    expect($data->toArray())->each->toHaveKey('created_at', now()->yesterday()->toDateString());
});
