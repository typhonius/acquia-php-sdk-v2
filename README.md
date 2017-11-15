
Acquia PHP SDK for CloudAPI v2
=

With the [original Acquia Cloud SDK](https://github.com/acquia/acquia-sdk-php) being deprecated and a [new version of Cloud API](https://cloud.acquia.com/api-docs/) being made available, this SDK aims to fill the gap and use more modern PHP packages to allow developers to continue to build tools that interact with the Acquia Cloud API.

## Installation

The SDK can be installed with [Composer](http://getcomposer.org) by adding this
library as a dependency to your composer.json file.

```json
{
    "require": {
        "typhonius/acquia-php-sdk-v2": "*"
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

$key_id = 'd0697bfc-7f56-4942-9205-b5686bf5b3f5';
$secret = 'D5UfO/4FfNBWn4+0cUwpLOoFzfP7Qqib4AoY+wYGsKE=';

$cloudapi = Client::factory([
    'key' => $key_id,
    'secret' => $secret,
]);

// Get all applications.
$applications = $cloudapi->applications();

// Get all environments of an application.
$environments = $cloudapi->environments($application->uuid);

// Get all servers in an environment.
$servers = $cloudapi->servers($environment->uuid);

```

## I just want to use this not develop against it

A Robo application has been created that uses this SDK and creates a command line tool for interacting with the API. [The application may be found here](https://github.com/typhonius/acquia_cli) using the acquia-api-v2 branch.