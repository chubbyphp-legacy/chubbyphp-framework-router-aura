# chubbyphp-framework-router-aura

[![Build Status](https://api.travis-ci.org/chubbyphp/chubbyphp-framework-router-aura.png?branch=master)](https://travis-ci.org/chubbyphp/chubbyphp-framework-router-aura)
[![Coverage Status](https://coveralls.io/repos/github/chubbyphp/chubbyphp-framework-router-aura/badge.svg?branch=master)](https://coveralls.io/github/chubbyphp/chubbyphp-framework-router-aura?branch=master)
[![Total Downloads](https://poser.pugx.org/chubbyphp/chubbyphp-framework-router-aura/downloads.png)](https://packagist.org/packages/chubbyphp/chubbyphp-framework-router-aura)
[![Monthly Downloads](https://poser.pugx.org/chubbyphp/chubbyphp-framework-router-aura/d/monthly)](https://packagist.org/packages/chubbyphp/chubbyphp-framework-router-aura)
[![Latest Stable Version](https://poser.pugx.org/chubbyphp/chubbyphp-framework-router-aura/v/stable.png)](https://packagist.org/packages/chubbyphp/chubbyphp-framework-router-aura)
[![Latest Unstable Version](https://poser.pugx.org/chubbyphp/chubbyphp-framework-router-aura/v/unstable)](https://packagist.org/packages/chubbyphp/chubbyphp-framework-router-aura)

## Description

Aura Router implementation for [chubbyphp-framework][1].

## Requirements

 * php: ^7.2
 * [aura/router][2]: ^3.1
 * [chubbyphp/chubbyphp-framework][1]: ^3.1

## Installation

Through [Composer](http://getcomposer.org) as [chubbyphp/chubbyphp-framework-router-aura][10].

```bash
composer require chubbyphp/chubbyphp-framework-router-aura "^1.0"
```

## Usage

```php
<?php

declare(strict_types=1);

namespace App;

use Chubbyphp\Framework\Application;
use Chubbyphp\Framework\ErrorHandler;
use Chubbyphp\Framework\Middleware\ExceptionMiddleware;
use Chubbyphp\Framework\Middleware\RouterMiddleware;
use Chubbyphp\Framework\RequestHandler\CallbackRequestHandler;
use Chubbyphp\Framework\Router\Aura\Router;
use Chubbyphp\Framework\Router\Route;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\Factory\ResponseFactory;
use Slim\Psr7\Factory\ServerRequestFactory;

$loader = require __DIR__.'/vendor/autoload.php';

set_error_handler([new ErrorHandler(), 'errorToException']);

$responseFactory = new ResponseFactory();

$app = new Application([
    new ExceptionMiddleware($responseFactory, true),
    new RouterMiddleware(new Router([
        Route::get('/hello/{name}', 'hello', new CallbackRequestHandler(
            function (ServerRequestInterface $request) use ($responseFactory) {
                $name = $request->getAttribute('name');
                $response = $responseFactory->createResponse();
                $response->getBody()->write(sprintf('Hello, %s', $name));

                return $response;
            }
        ), [], [Router::PATH_TOKENS => ['name' => '[a-z]+']])
    ]), $responseFactory),
]);

$app->emit($app->handle((new ServerRequestFactory())->createFromGlobals()));
```

## Copyright

Dominik Zogg 2020

[1]: https://packagist.org/packages/chubbyphp/chubbyphp-framework
[2]: https://packagist.org/packages/aura/router
[10]: https://packagist.org/packages/chubbyphp/chubbyphp-framework-router-aura
