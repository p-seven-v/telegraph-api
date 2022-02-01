# Telegra.ph API for PHP

[![Packagist](https://img.shields.io/packagist/v/p7v/telegraph-api.svg)](https://packagist.org/packages/p7v/telegraph-api)
[![License](https://img.shields.io/github/license/mashape/apistatus.svg)](LICENSE)

This package lets you work with [telegra.ph](http://telegra.ph) API.

## Contents

- [Installation](#installation)
- [Usage](#usage)
- [Changelog](#changelog)
- [Roadmap](#roadmap)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)

## Disclaimer

^1.0 version here is a copy of deploykit/telegraph-api project. That package is discontinued in favor of this one.
This package replaces that one, and for backward compatibility it even contains legacy namespace.

^2.0 is a completely reworked client.

## Installation

To get the latest version of Telegra.ph API client simply require the project using [Composer](https://getcomposer.org):

```bash
$ composer require p7v/telegraph-api
```

Or you can manually update your require block and run `composer update` if you choose so:

```json
{
    "require": {
        "p7v/telegraph-api": "^2.0"
    }
}
```

## Usage
All methods in Telegraph Client class correspond to API methods that are described in [Telegraph API documentation](http://telegra.ph/api). Each method would accept its own request object.

```php
$telegraph = new \P7v\TelegraphApi\Client();

$request = new CreateAccountRequest('short-name');
$request = $request->withAuthorName('author-name')->withAuthorUrl('https://example.com');

$telegraph->createAccount($request);
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Roadmap

All future features are documented in [Roadmap GitHub project](https://github.com/p7v/telegraph-api/projects/1).

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Alexey Plekhanov](https://github.com/alexsoft)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
