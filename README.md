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

* PHP 5.5+
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
(new \Josegonzalez\ErrorHandlers\Handler($config))->register();

// Enjoy throwing exceptions and reporting them upstream
throw new \Exception('Test Exception');
```

The registered handler returns false by default. This allows you to chain error handlers such that this package can handle reporting while another library can display user-friendly error messages.

### Available Handlers

The following are built-in handlers with their configuration options:

- `AirbrakeHandler`:: Uses the official [airbrake php](https://github.com/airbrake/phpbrake/) package.
    - `host`: (optional | default: `api.airbrake.io`)
    - `projectId`: (required | default: `null`)
    - `projectKey`: (required | default: `null`)
- `BugsnagHandler`: Uses the official [bugsnag php](https://github.com/bugsnag/bugsnag-php) package.
    - `apiKey`: (required | default: `null`)
    - `defaults`: (optional | default: `null`) Your bugsnag endpoint for enterprise users
    - `endpoint`: (optional | default: `true`) If we should register our default callbacks
- `MonologStreamHandler`: Uses the [monolog StreamHandler](https://github.com/seldaek/monolog).
    - `name`: (optional | default: `error`)
    - `handlerClass`: (optional | default: `Monolog\Handler\StreamHandler`)
    - `stream`: (optional | default: `log/error.log`)
    - `level`: (optional | default: `Monolog\Logger::Warning`)
- `NewrelicHandler`: Uses the `newrelic` [php extension](https://docs.newrelic.com/docs/agents/php-agent/getting-started/new-relic-php).
- `RaygunHandler`: Uses the official [raygun php](https://github.com/MindscapeHQ/raygun4php) package.
    - `apiKey`: (required | default: `null`)
- `SentryHandler`: Uses the official [sentry php](https://github.com/getsentry/sentry-php) package.
    - `dsn`: (required | default: `null`)
    - `callInstall`: (optional | default: `false`) Whether or not to call the `install` method on the client.

### Handler and Exception Modification

#### Modifying the client handler

Sometimes you may find it useful to modify the client. For instance, it may be necessary to add contextual information to the given client call. To do so, you can set the `clientCallback` configuration key:

```php
$config = [
    'handlers' => [
        'BugsnagHandler' => [
            'clientCallback' => function ($client) {
                // do something interesting to the client
                $client->setAppVersion('1.0.0');
                return $client;
            },
        ],
    ],
];
```

Note that the client should still respond to the existing reporting API provided by the upstream library. You may respond with a proxy library if desired, though returning the initial client is ideal.

> `$client` may be set to `null` inside of `clientCallback` if the handler is improperly configured.

#### Modifying the exception

If necessary, it is possible to modify the exception being used within a particular handler. Changes to the exception will persist only for the duration of that particular handler call.

To do so, set the `exceptionCallback` configuration key for a particular handler:

```php
$config = [
    'handlers' => [
        'BugsnagHandler' => [
            'exceptionCallback' => function ($exception) {
                // return null to skip reporting errors
                if ($exception instanceof \Error) {
                    return null;
                }
                return $exception;
            },
        ],
    ],
];
```

You may return another exception or `null`. In the latter case, the built-in handlers will skip reporting the given exception.

### Custom Handlers

Each handler should implement the `Josegonzalez\ErrorHandlers\Handler\HandlerInterface`. This interface contains a single method:

```php
public function handle($exception);
```

- PHP 5.x errors will be replaced with wrapper `ErrorException` instances before sent to the `handle` method.
- PHP 7.x errors extending `Throwable` will be replaced with wrapper `Josegonzalez\ErrorHandlers\Exception\PHP7ErrorException` instances before sent to the `handle` method.
- PHP Fatal errors will be replaced with wrapper `Josegonzalez\ErrorHandlers\Exception\FatalErrorException` instances before sent to the `handle` method.
- PHP Exceptions will be sent in, unmodified.

Custom handlers *should* extend the provided `Josegonzalez\ErrorHandlers\Handler\AbstractHandler` class. This gives them the ability to have configuration passed in via the provided `ConfigTrait` and custom `__construct()`.

### CakePHP Usage

You will want to setup at least the following configuration keys in your `config/app.php`:

- `Error.config`: Takes the same configuration array as you would give for normal php usage.

Next, configure the provided ErrorHandler classes in your `config/bootstrap.php`:

```php
// around line 100
$isCli = PHP_SAPI === 'cli';
if ($isCli) {
    (new \Josegonzalez\ErrorHandlers\Cake\ConsoleErrorHandler(Configure::read('Error')))->register();
} else {
    (new \Josegonzalez\ErrorHandlers\Cake\ErrorHandler(Configure::read('Error')))->register();
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

