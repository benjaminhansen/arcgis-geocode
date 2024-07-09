# PHP Library for the ArcGIS Geocode REST API

Provides an intuitive interface to use the ArcGIS Geocode REST API in any PHP application.

## Installation
```
composer require benjaminhansen/arcgis-geocode
```

## Usage
```php
<?php

require 'vendor/autoload.php';

use BenjaminHansen\ArcGIS\Geocode\Api\Suggest;
use BenjaminHansen\ArcGIS\Geocode\Api\FindAddressCandidates;

// make a request for suggestions based on the text provided
$suggest_request = new Suggest();
$suggest_request->labelsAsPostalCity()->text('1600 Pennsylvania Ave. SE, Washington, DC 20003');

// get the first suggestion returned
$suggestion = $suggest_request->first();

// or get all suggestions returned
// $suggestions = $suggest_request->all();

// use a suggestion to look up coordinates, etc
$all_candidates = $suggestion->candidates()->all();
$first_candidate = $suggestion->candidates()->first();
$last_candidate = $suggestion->candidates()->last();

// or you can provide the text and magicKey values directly
// $candidates_request = new FindAddressCandidates($suggestion->text, $suggestion->magicKey);

// get the first candidate returned
// $candidate = $candidates_request->first();

// get the lat/lon values from the returned object
$latitude = $first_candidate->latitude();
$longitude = $first_candidate->longitude();

```
