# An SDK for using the Metatrader4 API in PHP

Here are a few examples:

```php
$manager = new \D4T\MT4Sdk\Manager('<api-key>', '<mt4-api-endpoint>')

// creating a account
$account = $manager->createAccount([
    'email' => '1@1.com',
    'name' => 'My new campaign'
]);

```

```php
// listing all logins
$logins = $manager->accounts();

foreach($logins as $login) {
    echo $login;
}
```

## Installation

You can install the package via composer:

```bash
composer require dev4traders/mt4-sdk-php
```

You must also install Guzzle

```bash
composer require guzzlehttp/guzzle
```

## Usage

To get started, you must first new up an instance of `D4T\MT4Sdk\Manager`

```php
use D4T\MT4Sdk\Manager;

$manager = new \D4T\MT4Sdk\Manager('<api-key>', '<mt4-api-endpoint>')
```

## Testing

```php
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
