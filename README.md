
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

## Usage

Basic usage examples for the SDK.

```php
<?php

require 'vendor/autoload.php';

use AcquiaCloudApi\CloudApi\Client;

$key_id = 'd0697bfc-7f56-4942-9205-b5686bf5b3f5';
$secret = 'D5UfO/4FfNBWn4+0cUwpLOoFzfP7Qqib4AoY+wYGsKE=';

$cloudapi = Client::factory(array(
    'key' => $key_id,
    'secret' => $secret,
));

$applications = $cloudapi->applications();
```