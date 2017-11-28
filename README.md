
Acquia PHP SDK for CloudAPI v2
=

[![Build Status](https://travis-ci.org/typhonius/acquia-php-sdk-v2.svg?branch=master)](https://travis-ci.org/typhonius/acquia-php-sdk-v2)
[![Total Downloads](https://poser.pugx.org/typhonius/acquia-php-sdk-v2/downloads.png)](https://packagist.org/packages/typhonius/acquia-php-sdk-v2)
[![Coverage Status](https://coveralls.io/repos/github/typhonius/acquia-php-sdk-v2/badge.svg?branch=master)](https://coveralls.io/github/typhonius/acquia-php-sdk-v2?branch=master)
[![License](https://poser.pugx.org/typhonius/acquia-php-sdk-v2/license.png)](https://www.versioneye.com/user/projects/5a18bd670fb24f2125873c86#tab-dependencies)

[![Latest Stable Version](https://poser.pugx.org/typhonius/acquia-php-sdk-v2/v/stable.png)](https://packagist.org/packages/typhonius/acquia-php-sdk-v2)
[![Latest Unstable Version](https://poser.pugx.org/typhonius/acquia-php-sdk-v2/v/unstable.png)](https://packagist.org/packages/typhonius/acquia-php-sdk-v2)

With the [original Acquia Cloud SDK](https://github.com/acquia/acquia-sdk-php) being deprecated and a [new version of Cloud API](https://cloud.acquia.com/api-docs/) being made available, this SDK aims to fill the gap and use more modern PHP packages to allow developers to continue to build tools that interact with the Acquia Cloud API.

## Installation

The SDK can be installed with [Composer](http://getcomposer.org) by adding this
library as a dependency to your composer.json file.

```json
{
    "require": {
        "typhonius/acquia-php-sdk-v2": "^1.0.0"
    }
}
```

## Generating an API access token

To generate an API access token, login to [https://cloud.acquia.com](), then visit [https://cloud.acquia.com/#/profile/tokens](), and click ***Create Token***.

* Provide a label for the access token, so it can be easily identified. Click ***Create Token***.
* The token has been generated, copy the api key and api secret to a secure place. Make sure you record it now: you will not be able to retrieve this access token's secret again.


## Usage

Basic usage examples for the SDK.

```php
<?php

require 'vendor/autoload.php';

use AcquiaCloudApi\CloudApi\Client;
use AcquiaCloudApi\CloudApi\Connector;

$key = 'd0697bfc-7f56-4942-9205-b5686bf5b3f5';
$secret = 'D5UfO/4FfNBWn4+0cUwpLOoFzfP7Qqib4AoY+wYGsKE=';

$config = [
    'key' => $key,
    'secret' => $secret,
];
$connector = new Connector($config);
$cloudapi = Client::factory($connector);

// Get all applications.
$applications = $cloudapi->applications();

// Get all environments of an application.
$environments = $cloudapi->environments($application->uuid);

// Get all servers in an environment.
$servers = $cloudapi->servers($environment->uuid);

```

## I just want to talk to the API without having to write code

The [Acquia Cli Robo application](https://github.com/typhonius/acquia_cli) creates a command line tool for communicating with the API using this SDK. Its purpose is to provide a simple mechanism for interacting with the API without having to write a line of code.
