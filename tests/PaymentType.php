<?php

namespace LaracraftTech\LaravelUsefulAdditions\Tests;

use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulEnums;

if (PHP_VERSION_ID >= 80100) {
    enum PaymentType: int
    {
        use UsefulEnums;

        case Pending = 1;
        case Failed = 2;
        case Success = 3;
    }
}
