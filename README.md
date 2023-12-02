# chubbyphp-framework-router-aura

[![CI](https://github.com/chubbyphp/chubbyphp-framework-router-aura/workflows/CI/badge.svg?branch=master)](https://github.com/chubbyphp/chubbyphp-framework-router-aura/actions?query=workflow%3ACI)
[![Coverage Status](https://coveralls.io/repos/github/chubbyphp/chubbyphp-framework-router-aura/badge.svg?branch=master)](https://coveralls.io/github/chubbyphp/chubbyphp-framework-router-aura?branch=master)
[![Infection MSI](https://badge.stryker-mutator.io/github.com/chubbyphp/chubbyphp-framework-router-aura/master)](https://dashboard.stryker-mutator.io/reports/github.com/chubbyphp/chubbyphp-framework-router-aura/master)
[![Latest Stable Version](https://poser.pugx.org/chubbyphp/chubbyphp-framework-router-aura/v/stable.png)](https://packagist.org/packages/chubbyphp/chubbyphp-framework-router-aura)
[![Total Downloads](https://poser.pugx.org/chubbyphp/chubbyphp-framework-router-aura/downloads.png)](https://packagist.org/packages/chubbyphp/chubbyphp-framework-router-aura)
[![Monthly Downloads](https://poser.pugx.org/chubbyphp/chubbyphp-framework-router-aura/d/monthly)](https://packagist.org/packages/chubbyphp/chubbyphp-framework-router-aura)

[![bugs](https://sonarcloud.io/api/project_badges/measure?project=chubbyphp_chubbyphp-framework-router-aura&metric=bugs)](https://sonarcloud.io/dashboard?id=chubbyphp_chubbyphp-framework-router-aura)
[![code_smells](https://sonarcloud.io/api/project_badges/measure?project=chubbyphp_chubbyphp-framework-router-aura&metric=code_smells)](https://sonarcloud.io/dashboard?id=chubbyphp_chubbyphp-framework-router-aura)
[![coverage](https://sonarcloud.io/api/project_badges/measure?project=chubbyphp_chubbyphp-framework-router-aura&metric=coverage)](https://sonarcloud.io/dashboard?id=chubbyphp_chubbyphp-framework-router-aura)
[![duplicated_lines_density](https://sonarcloud.io/api/project_badges/measure?project=chubbyphp_chubbyphp-framework-router-aura&metric=duplicated_lines_density)](https://sonarcloud.io/dashboard?id=chubbyphp_chubbyphp-framework-router-aura)
[![ncloc](https://sonarcloud.io/api/project_badges/measure?project=chubbyphp_chubbyphp-framework-router-aura&metric=ncloc)](https://sonarcloud.io/dashboard?id=chubbyphp_chubbyphp-framework-router-aura)
[![sqale_rating](https://sonarcloud.io/api/project_badges/measure?project=chubbyphp_chubbyphp-framework-router-aura&metric=sqale_rating)](https://sonarcloud.io/dashboard?id=chubbyphp_chubbyphp-framework-router-aura)
[![alert_status](https://sonarcloud.io/api/project_badges/measure?project=chubbyphp_chubbyphp-framework-router-aura&metric=alert_status)](https://sonarcloud.io/dashboard?id=chubbyphp_chubbyphp-framework-router-aura)
[![reliability_rating](https://sonarcloud.io/api/project_badges/measure?project=chubbyphp_chubbyphp-framework-router-aura&metric=reliability_rating)](https://sonarcloud.io/dashboard?id=chubbyphp_chubbyphp-framework-router-aura)
[![security_rating](https://sonarcloud.io/api/project_badges/measure?project=chubbyphp_chubbyphp-framework-router-aura&metric=security_rating)](https://sonarcloud.io/dashboard?id=chubbyphp_chubbyphp-framework-router-aura)
[![sqale_index](https://sonarcloud.io/api/project_badges/measure?project=chubbyphp_chubbyphp-framework-router-aura&metric=sqale_index)](https://sonarcloud.io/dashboard?id=chubbyphp_chubbyphp-framework-router-aura)
[![vulnerabilities](https://sonarcloud.io/api/project_badges/measure?project=chubbyphp_chubbyphp-framework-router-aura&metric=vulnerabilities)](https://sonarcloud.io/dashboard?id=chubbyphp_chubbyphp-framework-router-aura)

## Description

Aura Router implementation for [chubbyphp-framework][1].

DEPRECATED: I suggest to use [chubbyphp-framework-router-fastroute][11].

## Requirements

 * php: ^8.0
 * [aura/router][2]: ^3.1
 * [chubbyphp/chubbyphp-framework][1]: ^5.0.3
 * [chubbyphp/chubbyphp-http-exception][3]: ^1.0.1
 * [psr/http-message][4]: ^1.0.1

## Installation

Through [Composer](http://getcomposer.org) as [chubbyphp/chubbyphp-framework-router-aura][10].

```bash
composer require chubbyphp/chubbyphp-framework-router-aura "^2.0"
```

## Usage

```php
<?php

declare(strict_types=1);

namespace App;

use Chubbyphp\Framework\Application;
use Chubbyphp\Framework\Middleware\ExceptionMiddleware;
use Chubbyphp\Framework\Middleware\RouterMiddleware;
use Chubbyphp\Framework\RequestHandler\CallbackRequestHandler;
use Chubbyphp\Framework\Router\Aura\Router;
use Chubbyphp\Framework\Router\Route;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\Factory\ResponseFactory;
use Slim\Psr7\Factory\ServerRequestFactory;

$loader = require __DIR__.'/vendor/autoload.php';

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
    ])),
]);

$app->emit($app->handle((new ServerRequestFactory())->createFromGlobals()));
```

## Copyright

2023 Dominik Zogg

[1]: https://packagist.org/packages/chubbyphp/chubbyphp-framework
[2]: https://packagist.org/packages/aura/router
[3]: https://packagist.org/packages/chubbyphp/chubbyphp-http-exception
[4]: https://packagist.org/packages/psr/http-message
[10]: https://packagist.org/packages/chubbyphp/chubbyphp-framework-router-aura
[11]: https://packagist.org/packages/chubbyphp/chubbyphp-framework-router-fastroute
