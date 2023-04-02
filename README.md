# A collection of useful Laravel additions!

[![Latest Version on Packagist](https://img.shields.io/packagist/v/laracraft-tech/laravel-useful-additions.svg?style=flat-square)](https://packagist.org/packages/laracraft-tech/laravel-useful-traits)
[![Tests](https://github.com/laracraft-tech/laravel-useful-additions/actions/workflows/run-tests.yml/badge.svg?branch=main)](https://github.com/laracraft-tech/laravel-useful-traits/actions/workflows/run-tests.yml)
[![Check & fix styling](https://github.com/laracraft-tech/laravel-useful-additions/actions/workflows/fix-php-code-style-issues.yml/badge.svg?branch=main)](https://github.com/laracraft-tech/laravel-useful-traits/actions/workflows/fix-php-code-style-issues.yml)
[![License](https://img.shields.io/packagist/l/laracraft-tech/laravel-useful-additions.svg?style=flat-square)](https://packagist.org/packages/laracraft-tech/laravel-useful-traits)
<!--[![Total Downloads](https://img.shields.io/packagist/dt/laracraft-tech/laravel-useful-additions.svg?style=flat-square)](https://packagist.org/packages/laracraft-tech/laravel-useful-traits)-->

Here we will share some useful Laravel additions we need in our daily work.

### Traits

- [`UsefulEnums`](#usefulenums)
- [`UsefulScopes`](#usefulscopes)
    - [`selectAllBut`](#selectallbut)
    - [`fromToday`](#fromtoday-fromyesterday)
    - [`fromYesterday`](#fromtoday-fromyesterday)
- [`RefreshDatabaseFast`](#refreshdatabasefast)

### Commands

- [`db:truncate`](#dbtruncate)

## Installation

You can install the package via composer:

```bash
composer require laracraft-tech/laravel-useful-additions
```

Then publish the config file with:

```bash
php artisan vendor:publish --tag="useful-additions-config"
```

## Traits

### UsefulEnums

This trait is only available with **PHP 8.1** or higher installed.

---

#### `names`, `values`, `array`
This could be very handy if you like to **loop** over all of your **enum** types, or you maybe want to use the enum as an array, for instance in a migration.

```php
use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulEnums;

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
use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulScopes;

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
use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulScopes;

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
So the first `migrate:fresh` takes a while (depending on how many migrations you have), and then it's incredible fast.

Optionally you can set `USEFUL_ADDITIONS_SEED_AFTER_FAST_DB_REFRESH` to `true` if you like to seed your database after the migration.

Also make sure to add the `.phpunit.database.checksum` to your `.gitignore` file!

***Pest:***
```php

use LaracraftTech\LaravelUsefulAdditions\Traits\RefreshDatabaseFast;

uses(RefreshDatabaseFast::class);

it('does_something', function() {
    // ...
});
```

***PHPUnit:***
```php
use LaracraftTech\LaravelUsefulAdditions\Traits\RefreshDatabaseFast;
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

## Commands

### db:truncate

---

This command truncates all the tables of your current database connection. Checkout `--help` to see arguments and options. 
It for instance, lets you also truncate only **specific** tables or disable **foreigen key checks** or maybe run in **force** mode.

```bash
php artisan db:truncate
```
```
INFO  Start truncating tables.

Truncating table: failed_jobs .............................................. 135ms DONE
Truncating table: migrations ................................................ 87ms DONE
Truncating table: password_reset_tokens ..................................... 79ms DONE
Truncating table: personal_access_tokens .................................... 86ms DONE
Truncating table: users ..................................................... 78ms DONE

INFO  Finished truncating tables.
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
