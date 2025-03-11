# PHP Library for the ArcGIS Geocode REST API

Provides an intuitive interface to use the ArcGIS Geocode REST API in any PHP application.

## Installation
```
composer require benjaminhansen/arcgis-geocode
```

## Basic Usage
```php
<?php

require 'vendor/autoload.php';

use BenjaminHansen\ArcGIS\Geocode\Api\Suggest;

// make a request for suggestions based on the text provided
$suggest = new Suggest('1600 Pennsylvania Ave. SE, Washington, DC 20003');
$suggest->labelsAsPostalCity();

// get the latitude and longitude of the first suggestion returned
$latitude = $suggest->latitude(precision: 5);
$longitude = $suggest->longitude(precision: 5);

// get the full address of the first suggestion returned
$address = $suggest->address();

```
