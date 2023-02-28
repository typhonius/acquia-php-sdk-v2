
Acquia PHP SDK for CloudAPI v2
=

[![Build Status](https://github.com/typhonius/acquia-php-sdk-v2/actions/workflows/php.yml/badge.svg)](https://github.com/typhonius/acquia-php-sdk-v2/actions/workflows/php.yml)
[![Total Downloads](https://poser.pugx.org/typhonius/acquia-php-sdk-v2/downloads.png)](https://packagist.org/packages/typhonius/acquia-php-sdk-v2)
[![Coverage Status](https://codecov.io/gh/typhonius/acquia-php-sdk-v2/branch/master/graph/badge.svg)](https://codecov.io/gh/typhonius/acquia-php-sdk-v2)
[![Quality Status](https://scrutinizer-ci.com/g/typhonius/acquia-php-sdk-v2/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/typhonius/acquia-php-sdk-v2/)
[![Mutation testing badge](https://img.shields.io/endpoint?style=flat&url=https%3A%2F%2Fbadge-api.stryker-mutator.io%2Fgithub.com%2Ftyphonius%2Facquia-php-sdk-v2%2Fmaster)](https://dashboard.stryker-mutator.io/reports/github.com/typhonius/acquia-php-sdk-v2/master)

[![License](https://poser.pugx.org/typhonius/acquia-php-sdk-v2/license.png)](https://www.versioneye.com/user/projects/5a18bd670fb24f2125873c86#tab-dependencies)
[![Latest Stable Version](https://poser.pugx.org/typhonius/acquia-php-sdk-v2/v/stable.png)](https://packagist.org/packages/typhonius/acquia-php-sdk-v2)
[![Latest Unstable Version](https://poser.pugx.org/typhonius/acquia-php-sdk-v2/v/unstable.png)](https://packagist.org/packages/typhonius/acquia-php-sdk-v2)

This library provides the capability to develop tooling which integrates with the [new version (2.0) of Cloud API](https://cloud.acquia.com/api-docs/).

The [original Acquia Cloud SDK](https://github.com/acquia/acquia-sdk-php) has been deprecated so build tools requiring modern PHP versions and packages should use this library.

## Installation

The SDK can be installed with [Composer](http://getcomposer.org) by adding this
library as a dependency to your composer.json file.

```json
{
    "require": {
        "typhonius/acquia-php-sdk-v2": "^2"
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

use AcquiaCloudApi\Connector\Client;
use AcquiaCloudApi\Connector\Connector;
use AcquiaCloudApi\Endpoints\Applications;
use AcquiaCloudApi\Endpoints\Environments;
use AcquiaCloudApi\Endpoints\Servers;
use AcquiaCloudApi\Endpoints\DatabaseBackups;
use AcquiaCloudApi\Endpoints\Variables;
use AcquiaCloudApi\Endpoints\Account;

$key = 'd0697bfc-7f56-4942-9205-b5686bf5b3f5';
$secret = 'D5UfO/4FfNBWn4+0cUwpLOoFzfP7Qqib4AoY+wYGsKE=';

$config = [
    'key' => $key,
    'secret' => $secret,
];

$connector = new Connector($config);
$client = Client::factory($connector);

$application = new Applications($client);
$environment = new Environments($client);
$server      = new Servers($client);
$backup      = new DatabaseBackups($client);
$variable    = new Variables($client);
$account     = new Account($client);

// Get all applications.
$applications = $application->getAll();

// Get all environments of an application.
$environments = $environment->getAll($applicationUuid);

// Get all servers in an environment.
$servers = $server->getAll($environmentUuid);

// Create DB backup
$backup->create($environmentUuid, $dbName);

// Set an environment varible
$variable->create($environmentUuid, 'test_variable', 'test_value');

// Download Drush 9 aliases to a temp directory
$client->addQuery('version', '9');
$result = $account->getDrushAliases();
$drushArchive = tempnam(sys_get_temp_dir(), 'AcquiaDrushAliases') . '.tar.gz';
file_put_contents($drushArchive, $aliases, LOCK_EX);

// Download database backup
// file_put_contents loads the response into memory. This is okay for small things like Drush aliases, but not for database backups.
// Use curl.options to stream data to disk and minimize memory usage.
$client->addOption('sink', $filepath);
$client->addOption('curl.options', ['CURLOPT_RETURNTRANSFER' => true, 'CURLOPT_FILE' => $filepath]);
$backup->download($environmentUuid, $dbName, $backupId);
```

## Documentation

Documentation of each of the classes and methods has been automatically generated by phpDocumentor and exists in the `gh-pages` branch. [This is available for browsing on GitHub](https://typhonius.github.io/acquia-php-sdk-v2/).

## I just want to talk to the API without having to write code

The [Acquia Cli Robo application](https://github.com/typhonius/acquia_cli) creates a command line tool for communicating with the API using this SDK. Its purpose is to provide a simple mechanism for interacting with the API without having to write a line of code.
