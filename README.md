# PHP BattlEye Global Ban

[![Latest Version on Packagist](https://img.shields.io/packagist/v/battleyephp/global-ban.svg?style=flat-square)](https://packagist.org/packages/battleyephp/global-ban)
[![Tests](https://img.shields.io/github/actions/workflow/status/battleyephp/global-ban/tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/battleyephp/global-ban/actions/workflows/tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/battleyephp/global-ban.svg?style=flat-square)](https://packagist.org/packages/battleyephp/global-ban)

It provides BattlEye Global Ban checker.  
You can check if any GUID is banned globally.

> Currently only **Arma 3** is supported by default,
> but you can provide **Arma 2 OA** or **DayZ**
> BattlEye hostname with port to check it too.

## Installation

> **Requires [PHP 8.2+](https://php.net/releases/)**

> **Requires [ext-sockets](https://www.php.net/manual/en/book.sockets.php)**

You can install the package via composer:

```bash
composer require battleyephp/global-ban
```

## Usage

To check if a Steam account has a global ban:

```php
use BattlEye\GlobalBan\Checker;
use BattlEye\Guid\Guid;

$checker = new Checker();
$guid = Guid::fromSteamId64(76561198066209976);

$ban = $checker->check($guid);

if ($ban->exists) {
    echo sprintf('User is banned: %s', $ban->reason);
} else {
    echo 'User is not banned';
}
```

## Testing

```bash
composer test
```
