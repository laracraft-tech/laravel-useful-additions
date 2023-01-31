<?php

use LaracraftTech\LaravelUsefulTraits\Enums\EnumToArray;

it('can give array of enum', function () {
    enum PaymentType: int
    {
        use EnumToArray;

        case Pending = 1;
        case Failed = 2;
        case Success = 3;
    }

    expect(PaymentType::names())->toBe(['Pending', 'Failed', 'Success'])
        ->and(PaymentType::values())->toBe([1, 2, 3])
        ->and(PaymentType::array())->toBe([
            'Pending' => 1,
            'Failed' => 2,
            'Success' => 3,
        ]);
});
