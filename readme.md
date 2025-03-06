# PHP Library for the ArcGIS Geocode REST API

Provides an intuitive interface to use the ArcGIS Geocode REST API in any PHP application.

## Installation
```
composer require benjaminhansen/arcgis-geocode
```

## Example Usage
```php
<?php

require 'vendor/autoload.php';

use BenjaminHansen\ArcGIS\Geocode\Api\Suggest;

// make a request for suggestions based on the text provided
$api = new Suggest();
$$api->labelsAsPostalCity()
    ->text('1600 Pennsylvania Ave. SE, Washington, DC 20003');

// get the latitude and longitude of the first suggestion returned
$latitude = $api->latitude(precision: 5);
$longitude = $api->longitude(precision: 5);

```
