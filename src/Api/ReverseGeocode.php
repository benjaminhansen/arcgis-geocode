<?php

namespace BenjaminHansen\ArcGIS\Geocode\Api;

use BenjaminHansen\ArcGIS\Geocode\Models\ReverseRecord;
use BenjaminHansen\ArcGIS\Geocode\Traits\ApiBase;
use GuzzleHttp\Client as HttpClient;

class ReverseGeocode
{
    use ApiBase;

    public function __construct(?float $lat = null, ?float $lon = null)
    {
        $this->http_client = new HttpClient([
            'http_errors' => false,
        ]);

        // set the base URL for all requests on this class
        $this->setBaseUrl('https://geocode.arcgis.com/arcgis/rest/services/World/GeocodeServer/reverseGeocode');

        // default to json format
        $this->asJson();

        // if we have a lat and lon, set them
        if ($lat && $lon) {
            $this->location($lat, $lon);
        }
    }

    public function location(float $lat, float $lon): self
    {
        $this->url_parameters['location'] = "{$lon},{$lat}";

        return $this;
    }

    public function get(): ReverseRecord
    {
        $url_parameter_string = http_build_query($this->url_parameters);
        $base_url = $this->getBaseUrl();
        $request_url = "{$base_url}?{$url_parameter_string}";
        $http_request = $this->http_client->get($request_url);
        $data = json_decode($http_request->getBody()->getContents());

        return new ReverseRecord($data);
    }
}
