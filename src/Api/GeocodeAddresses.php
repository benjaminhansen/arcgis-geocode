<?php

namespace BenjaminHansen\ArcGIS\Geocode\Api;

use BenjaminHansen\ArcGIS\Geocode\Models\GeocodeRecord;
use BenjaminHansen\ArcGIS\Geocode\Traits\ApiBase;
use GuzzleHttp\Client as HttpClient;
use Illuminate\Support\Collection;
use Exception;

class GeocodeAddresses
{
    use ApiBase;

    public function __construct()
    {
        $this->http_client = new HttpClient([
            'http_errors' => false
        ]);

        // set the base URL for all requests on this class
        $this->setBaseUrl("https://geocode.arcgis.com/arcgis/rest/services/World/GeocodeServer/geocodeAddresses");

        // default to json format
        $this->asJson();
    }

    public function category(string $category): self
    {
        $this->url_parameters['category'] = $category;
        return $this;
    }

    public function sourceCountry(string $country): self
    {
        $this->url_parameters['sourceCountry'] = $country;
        return $this;
    }

    public function outSR(string $outsr): self
    {
        $this->url_parameters['outSR'] = $outsr;
        return $this;
    }

    public function locationType(string $type): self
    {
        $this->url_parameters['locationType'] = $type;
        return $this;
    }

    public function searchExtent(string $extent): self
    {
        $this->url_parameters['searchExtent'] = $extent;
        return $this;
    }

    public function langCode(string $code): self
    {
        $this->url_parameters['langCode'] = $code;
        return $this;
    }

    public function outFields(array $fields): self
    {
        $this->url_parameters['outFields'] = implode(",", $fields);
        return $this;
    }

    public function labelsAsPostalCity(): self
    {
        $this->url_parameters['preferredLabelValues'] = 'postalCity';
        return $this;
    }

    public function labelsAsLocalCity(): self
    {
        $this->url_parameters['preferredLabelValues'] = 'localCity';
        return $this;
    }

    public function labelsAsMatchedCity(): self
    {
        $this->url_parameters['preferredLabelValues'] = 'matchedCity';
        return $this;
    }

    public function labelsAsPrimaryStreet(): self
    {
        $this->url_parameters['preferredLabelValues'] = 'primaryStreet';
        return $this;
    }

    public function labelsAsMatchedStreet(): self
    {
        $this->url_parameters['preferredLabelValues'] = 'matchedStreet';
        return $this;
    }

    public function addresses(array $addresses): self
    {
        $this->url_parameters['addresses'] = json_encode([
            'records' => $addresses
        ]);
        return $this;
    }

    public function get(): Collection
    {
        if(!isset($this->url_parameters['token'])) {
            throw new Exception("[token] is required for this API operation!");
        }

        $url_parameter_string = http_build_query($this->url_parameters);
        $base_url = $this->getBaseUrl();
        $request_url = "{$base_url}?{$url_parameter_string}";
        $http_request = $this->http_client->get($request_url);
        $data = json_decode($http_request->getBody()->getContents());

        $return = [];

        foreach($data?->locations ?? [] as $location) {
            $return[] = new GeocodeRecord($location);
        }

        return collect($return);
    }
}
