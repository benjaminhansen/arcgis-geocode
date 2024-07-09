<?php

namespace BenjaminHansen\ArcGIS\Geocode\Api;

use GuzzleHttp\Client as HttpClient;
use Illuminate\Support\Collection;
use BenjaminHansen\ArcGIS\Geocode\Models\Suggestion;
use BenjaminHansen\ArcGIS\Geocode\Models\Candidate;
use BenjaminHansen\ArcGIS\Geocode\Traits\ApiBase;

class FindAddressCandidates
{
    use ApiBase;

    public function __construct(Suggestion|string $arg1, string $arg2 = null)
    {
        $this->http_client = new HttpClient([
            'http_errors' => false
        ]);

        // set the base URL for all requests on this class
        $this->setBaseUrl("https://geocode.arcgis.com/arcgis/rest/services/World/GeocodeServer/findAddressCandidates");

        // we have passed the suggestion in as a full object
        if($arg1 instanceof Suggestion) {
            $this->singleLine($arg1->text);
            $this->magicKey($arg1->magicKey);
        }

        // we have passed the text and magicKey as strings
        if($arg1 && $arg2 && !$arg1 instanceof Suggestion) {
            $this->singleLine($arg1);
            $this->magicKey($arg2);
        }

        // default to json format
        $this->asJson();
    }

    private function singleLine(string $line): self
    {
        $this->url_parameters['SingleLine'] = $line;
        return $this;
    }

    private function magicKey(string $key): self
    {
        $this->url_parameters['magicKey'] = $key;
        return $this;
    }

    public function first(): Candidate
    {
        return $this->all()->first();
    }

    public function last(): Candidate
    {
        return $this->all()->last();
    }

    public function all(): Collection
    {
        $base_url = $this->getBaseUrl();
        $url_parameters = http_build_query($this->url_parameters);
        $request_url = "{$base_url}?{$url_parameters}";
        $http_request = $this->http_client->get($request_url);
        $data = json_decode($http_request->getBody()->getContents());

        $return = [];

        foreach($data?->candidates ?? [] as $candidate) {
            $return[] = new Candidate($candidate);
        }

        return collect($return);
    }
}
