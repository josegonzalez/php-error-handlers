[![Build Status](https://img.shields.io/travis/josegonzalez/php-error-handlers/master.svg?style=flat-square)](https://travis-ci.org/josegonzalez/php-error-handlers)
[![Coverage Status](https://img.shields.io/coveralls/josegonzalez/php-error-handlers.svg?style=flat-square)](https://coveralls.io/r/josegonzalez/php-error-handlers?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/josegonzalez/php-error-handlers.svg?style=flat-square)](https://packagist.org/packages/josegonzalez/php-error-handlers)
[![Latest Stable Version](https://img.shields.io/packagist/v/josegonzalez/php-error-handlers.svg?style=flat-square)](https://packagist.org/packages/josegonzalez/php-error-handlers)
[![Documentation Status](https://readthedocs.org/projects/php-error-handlers/badge/?version=latest&style=flat-square)](https://readthedocs.org/projects/php-error-handlers/?badge=latest)
[![Gratipay](https://img.shields.io/gratipay/josegonzalez.svg?style=flat-square)](https://gratipay.com/~josegonzalez/)

# Error Handlers

A package that includes wrappers for popular error handling services.

Includes an integration library for CakePHP 3.

## Requirements

* PHP 5.4+
* Patience

## Installation

```shell
# install it
composer require josegonzalez/php-error-handlers

# load it
bin/cake plugin load Josegonzalez/ErrorHandlers
```

## Usage

You can register the `Handler` class as a handler of php errors and exceptions.

```php
// Create an array of configuration data to pass to the handler class
$config = [
    'handlers' => [
        // *Can* be the class name, not-namespaced
        // The namespace will be "interpolated" in such cases
        'NewrelicHandler' => [
        ],
        // Can also include the full namespace
        'Josegonzalez\ErrorHandlers\Handler\BugsnagHandler' => [
            'apiKey' => 'YOUR_API_KEY_HERE'
        ],
        // Invalid handlers will be ignored
        'InvalidHandler' => [
        ],
    ],
];

// Register the error handler
(new \Josegonzalez\ErrorHandlers\Error\Handler($config))->register();

// Enjoy throwing exceptions and reporting them upstream
throw new \Exception('Test Exception');
```

The registered handler returns false by default. This allows you to chain error handlers such that this package can handle reporting while another library can display user-friendly error messages.

### Available Handlers

The following are built-in handlers with their configuration options:

- `AirbrakeHandler`:
    - `projectId`
    - `projectKey`
- `BugsnagHandler`:
    - `apiKey`
- `MonologStreamHandler`:
    - `name`
    - `handlerClass`
    - `stream`
    - `level`
- `NewrelicHandler`
- `RaygunHandler`:
    - `apiKey`
- `SentryHandler`:
    - `dsn`

### Custom Handlers

Each handler should implement the `Josegonzalez\ErrorHandlers\Handler\HandlerInterface`. This interface contains a single method:

```php
public function handle($exception);
```

- PHP 5.x errors will be replaced with wrapper `ErrorException` instances before sent to the `handle` method.
- PHP 7.x errors extending `Throwable` will be replaced with wrapper `Josegonzalez\Error\Exception\PHP7ErrorException` instances before sent to the `handle` method.
- PHP Fatal errors will be replaced with wrapper `Josegonzalez\Error\Exception\FatalErrorException` instances before sent to the `handle` method.
- PHP Exceptions will be sent in, unmodified.

Custom handlers *should* extend the provided `Josegonzalez\ErrorHandler\Handler\AbstractHandler` class. This gives them the ability to have configuration passed in via the provided `ConfigTrait` and custom `__construct()`.

### CakePHP Usage

You will want to setup at least the following configuration keys in your `config/app.php`:

- `Error.config`: Takes the same configuration array as you would give for normal php usage.

Next, configure the provided ErrorHandler classes in your `config/bootstrap.php`:

```php
// around line 100
$isCli = PHP_SAPI === 'cli';
if ($isCli) {
    (new \Josegonzalez\ErrorHandlers\Console\ConsoleErrorHandler(Configure::read('Error')))->register();
} else {
    (new \Josegonzalez\ErrorHandlers\Error\ErrorHandler(Configure::read('Error')))->register();
}
```

## Running Tests

Yup, the tests require CakePHP. Pull requests welcome!

## License

The MIT License (MIT)

Copyright (c) 2015 Jose Diaz-Gonzalez

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.

