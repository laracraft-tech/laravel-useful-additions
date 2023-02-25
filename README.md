# A collection of useful Laravel traits!

[![Latest Version on Packagist](https://img.shields.io/packagist/v/laracraft-tech/laravel-useful-traits.svg?style=flat-square)](https://packagist.org/packages/laracraft-tech/laravel-useful-traits)
[![Tests](https://github.com/laracraft-tech/laravel-useful-traits/actions/workflows/run-tests.yml/badge.svg?branch=main)](https://github.com/laracraft-tech/laravel-useful-traits/actions/workflows/run-tests.yml)
[![Check & fix styling](https://github.com/laracraft-tech/laravel-useful-traits/actions/workflows/fix-php-code-style-issues.yml/badge.svg?branch=main)](https://github.com/laracraft-tech/laravel-useful-traits/actions/workflows/fix-php-code-style-issues.yml)
[![License](https://img.shields.io/packagist/l/laracraft-tech/laravel-useful-traits.svg?style=flat-square)](https://packagist.org/packages/laracraft-tech/laravel-useful-traits)
<!--[![Total Downloads](https://img.shields.io/packagist/dt/laracraft-tech/laravel-useful-traits.svg?style=flat-square)](https://packagist.org/packages/laracraft-tech/laravel-useful-traits)-->

Here we will over time share some useful Laravel traits we need in our daily work.

### Traits

- [`UsefulEnums`](#usefulenums)
- [`UsefulScopes`](#usefulscopes)
    - [`selectAllBut`](#selectallbut)
    - [`fromToday`](#fromtoday-fromyesterday)
    - [`fromYesterday`](#fromtoday-fromyesterday)
- [`RefreshDatabaseFast`](#refreshdatabasefast)

## Installation

You can install the package via composer:

```bash
composer require laracraft-tech/laravel-useful-traits
```

Then publish the config file with:

```bash
php artisan vendor:publish --tag="useful-traits-config"
```

## Usage

The following traits are provided in the `LaracraftTech`-namespace:

### UsefulEnums

---

#### `names`, `values`, `array`
This could be very handy if you like to **loop** over all of your **enum** types, or you maybe want to use the enum as an array, for instance in a migration.

```php
use LaracraftTech\LaravelUsefulTraits\UsefulEnums;

enum PaymentType: int
{
    use UsefulEnums;

    case Pending = 1;
    case Failed = 2;
    case Success = 3;
}

PaymentType::names();   // return ['Pending', 'Failed', 'Success']
PaymentType::values();  // return [1, 2, 3]
PaymentType::array();   // return ['Pending' => 1, 'Failed' => 2, 'Success' => 3]
```

### UsefulScopes

---

#### `selectAllBut`

Select all columns but given excluded array.

```php
use LaracraftTech\LaravelUsefulTraits\UsefulScopes;

$class = new class extends Model
{
    use UsefulScopes;

    protected $timestamps = false;
    protected $table = 'scope_tests';
};

$class->create([
    'foo' => 'foo',
    'bar' => 'bar',
    'quz' => 'quz',
]);

$class::query()->selectAllBut(['foo'])->first()->toArray();
// return ['bar' => 'bar', 'quz' => 'quz']
```
***Note***: Since you **can't** do a native "**select all but** x,y,z" in mysql, we need to query (and cache) the existing columns of the table,
and then exclude the given columns which should be **ignored** (not selected) from the existing columns.

***Cache***: Column names of each table will be cached **until** contents of migrations **directory** is added or deleted.
**Modifying** the contents of files inside the migrations directory will not re-cache the columns.
Consider to **clear the cache** whenever you make a new **deployment/migration**!

---

#### `fromToday`, `fromYesterday`

Select all entries created today or yesterday.

```php
use LaracraftTech\LaravelUsefulTraits\UsefulScopes;

$class = new class extends Model
{
    use UsefulScopes;

    protected $timestamps = true;
    protected $table = 'scope_tests';
};

$class->create(['foo' => 'foo1', 'bar' => 'bar1', 'quz' => 'quz1']);
$class->create(['foo' => 'foo2', 'bar' => 'bar2', 'quz' => 'quz2', 'created_at' => now()->yesterday()]);

$class::select('foo')->fromToday()->first()->toArray(); // return ['foo' => 'foo1']
$class::select('foo')->fromYesterday()->first()->toArray(); // return ['foo' => 'foo2']
```

### RefreshDatabaseFast

---

This is a trait which makes the migration of your database in your test suite much, **much faster**!
The base idea comes from [Mayahi](https://mayahi.net/laravel/make-refresh-database-trait-much-faster/).
It basically **only** migrates your database if the **migration** files has **changed**.
So the first `migrate:fresh` takes awhile (depending on how many migrations you have), and then it's incredible fast.

Optionally you can set `USEFUL_TRAITS_SEED_AFTER_FAST_DB_REFRESH` to `true` if you like to seed your database after the migration.

Also make sure to add the `.phpunit.database.checksum` to your `.gitignore` file!

***Pest:***
```php
// Pest.php

use LaracraftTech\LaravelUsefulTraits\RefreshDatabaseFast;
use Tests\TestCase;

uses(
    Tests\TestCase::class,
    RefreshDatabaseFast::class
)->in('Feature');
```

***PHPUnit:***
```php
use LaracraftTech\LaravelUsefulTraits\RefreshDatabaseFast;
use Tests\TestCase;

class MyTest extends TestCase
{
    use RefreshDatabaseFast;
    
    /** @test **/
    public function it_does_something()
    {
        // ...
    }
}
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Zacharias Creutznacher](https://github.com/laracraft-tech)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
