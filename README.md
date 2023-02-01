# A collection of useful Laravel traits!

[![Latest Version on Packagist](https://img.shields.io/packagist/v/laracraft-tech/laravel-useful-traits.svg?style=flat-square)](https://packagist.org/packages/laracraft-tech/laravel-useful-traits)
[![Tests](https://github.com/laracraft-tech/laravel-useful-traits/actions/workflows/run-tests.yml/badge.svg?branch=main)](https://github.com/laracraft-tech/laravel-useful-traits/actions/workflows/run-tests.yml)
[![Check & fix styling](https://github.com/laracraft-tech/laravel-useful-traits/actions/workflows/fix-php-code-style-issues.yml/badge.svg?branch=main)](https://github.com/laracraft-tech/laravel-useful-traits/actions/workflows/fix-php-code-style-issues.yml)
[![License](https://img.shields.io/packagist/l/laracraft-tech/laravel-useful-traits.svg?style=flat-square)](https://packagist.org/packages/laracraft-tech/laravel-useful-traits)
<!--[![Total Downloads](https://img.shields.io/packagist/dt/laracraft-tech/laravel-useful-traits.svg?style=flat-square)](https://packagist.org/packages/laracraft-tech/laravel-useful-traits)-->

Here we will over time share some useful Laravel traits we need in our daily work.

## Installation

You can install the package via composer:

```bash
composer require laracraft-tech/laravel-useful-traits
```

## Usage

The following traits are provided in the `LaracraftTech`-namespace:

### UsefulScopes

#### `selectAllBut`

Select all columns but given excluded array.

```php
use LaracraftTech\LaravelUsefulTraits\UsefulScopes;

DB::table('scope_test_table')->insert([
    'foo' => 'foo',
    'bar' => 'bar',
    'quz' => 'quz',
]);

$class = new class extends Model
{
    use UsefulScopes;

    protected $table = 'scope_test_table';
};

$class::query()->selectAllBut(['foo'])->first()->toArray();
// return ['bar' => 'bar', 'quz' => 'quz']
```
***Note***: Since you can't do a native "select all but x,y,z" in mysql, we need to query (and cache) the existing columns of the table,
and then exclude the given columns which should be ignored (not selected) from the existing columns.

***Cache***: Column names of each table will be cached until contents of migrations directory is added or deleted.
Modifying the contents of files inside the migrations directory will not re-cache the columns.
Consider to clear the cache whenever you make a new deployment/migration!

### UsefulEnums

#### `names, values, array`

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

***Note***: Since you can't do a native "select all but x,y,z" in mysql, we need to query (and cache) the existing columns of the table,
and then exclude the given columns which should be ignored (not selected) from the existing columns.

***Cache***: Column names of each table will be cached until contents of migrations directory is added or deleted.
Modifying the contents of files inside the migrations directory will not re-cache the columns.
Consider to clear the cache whenever you make a new deployment/migration!

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
