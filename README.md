[![Build Status](https://img.shields.io/travis/josegonzalez/cakephp-error-handlers/master.svg?style=flat-square)](https://travis-ci.org/josegonzalez/cakephp-error-handlers)
[![Coverage Status](https://img.shields.io/coveralls/josegonzalez/cakephp-error-handlers.svg?style=flat-square)](https://coveralls.io/r/josegonzalez/cakephp-error-handlers?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/josegonzalez/cakephp-error-handlers.svg?style=flat-square)](https://packagist.org/packages/josegonzalez/cakephp-error-handlers)
[![Latest Stable Version](https://img.shields.io/packagist/v/josegonzalez/cakephp-error-handlers.svg?style=flat-square)](https://packagist.org/packages/josegonzalez/cakephp-error-handlers)
[![Documentation Status](https://readthedocs.org/projects/cakephp-error-handlers/badge/?version=latest&style=flat-square)](https://readthedocs.org/projects/cakephp-error-handlers/?badge=latest)
[![Gratipay](https://img.shields.io/gratipay/josegonzalez.svg?style=flat-square)](https://gratipay.com/~josegonzalez/)

# CakePHP Error Handlers

A package that includes CakePHP wrappers for popular error handling services.

## Requirements

* CakePHP 3.x
* PHP 5.4+
* Patience

## Installation

```shell
# install it
composer require josegonzalez/cakephp-error-handlers

# load it
bin/cake plugin load Josegonzalez/ErrorHandlers
```

## Usage

You will want to setup at least the following configuration keys:

- `Error.handlerClass`: The fully qualified namespace of a handler class. They are currently as follows:
    - `\Josegonzalez\ErrorHandlers\Handler\AirbrakeHandler`
    - `\Josegonzalez\ErrorHandlers\Handler\BugsnagHandler`
    - `\Josegonzalez\ErrorHandlers\Handler\NewrelicHandler`
    - `\Josegonzalez\ErrorHandlers\Handler\RaygunHandler`
    - `\Josegonzalez\ErrorHandlers\Handler\SentryHandler`
- `Error.handlerConfig`: An array of configuration data for each service

## TODO

- Document `Error.handlerConfig`
- Add the ability to add extra data
- Extra data filtering
- Add the ability to "mute" exceptions
- Use an external set of libraries for exception services

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

