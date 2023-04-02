<?php

use LaracraftTech\LaravelUsefulAdditions\Tests\PaymentType;

it('can give array of enum', function () {
    expect(PaymentType::names())->toBe(['Pending', 'Failed', 'Success'])
        ->and(PaymentType::values())->toBe([1, 2, 3])
        ->and(PaymentType::array())->toBe([
            'Pending' => 1,
            'Failed' => 2,
            'Success' => 3,
        ]);
})->skip(PHP_VERSION_ID < 80100, 'Only since PHP 8.1');
