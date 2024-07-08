<?php

namespace BenjaminHansen\ArcGIS\Geocode\Api;

use GuzzleHttp\Client as HttpClient;
use BenjaminHansen\ArcGIS\Geocode\Models\Suggestion;
use BenjaminHansen\ArcGIS\Geocode\Traits\ApiBase;
use Illuminate\Support\Collection;

class Suggest
{
    use ApiBase;

    public function __construct()
    {
        $this->http_client = new HttpClient([
            'http_errors' => false
        ]);

        // set the base URL for all requests on this class
        $this->setBaseUrl("https://geocode.arcgis.com/arcgis/rest/services/World/GeocodeServer/suggest");

        // default to json format
        $this->asJson();

        // default to 10 maxSuggestions
        $this->maxSuggestions();

        // default to USA
        $this->asUSA();
    }

    public function asUSA(): self
    {
        $this->countryCode('USA')->sourceCountry('USA');
        return $this;
    }

    public function maxSuggestions(int $suggestions = 10): self
    {
        $this->url_parameters['maxSuggestions'] = $suggestions;
        return $this;
    }

    public function countryCode(string $country_code): self
    {
        $this->url_parameters['countryCode'] = $country_code;
        return $this;
    }

    public function sourceCountry(string $country_code): self
    {
        $this->url_parameters['sourceCountry'] = $country_code;
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

    public function location(string $location): self
    {
        $this->url_parameters['location'] = $location;
        return $this;
    }

    public function category(string $category): self
    {
        $this->url_parameters['category'] = $category;
        return $this;
    }

    public function searchExtent(string $extent): self
    {
        $this->url_parameters['searchExtent'] = $extent;
        return $this;
    }

    public function text(string $search_text): self
    {
        $this->url_parameters['text'] = $search_text;
        return $this;
    }

    public function callback(string $callback): self
    {
        $this->url_parameters['callback'] = $callback;
        return $this;
    }

    public function noCollections(): self
    {
        $this->url_parameters['returnCollections'] = 'false';
        return $this;
    }

    public function first(): Suggestion
    {
        return $this->get()->first();
    }

    public function last(): Suggestion
    {
        return $this->get()->last();
    }

    public function get(): Collection
    {
        $url_parameter_string = http_build_query($this->url_parameters);
        $base_url = $this->getBaseUrl();
        $request_url = "{$base_url}?{$url_parameter_string}";
        $http_request = $this->http_client->get($request_url);
        $data = json_decode($http_request->getBody()->getContents());

        $return = [];

        foreach($data?->suggestions ?? [] as $suggestion) {
            $return[] = new Suggestion($suggestion);
        }

        return collect($return);
    }
}
