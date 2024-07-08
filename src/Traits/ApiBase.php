<?php

namespace BenjaminHansen\ArcGIS\Geocode\Traits;

use GuzzleHttp\Client as HttpClient;

trait ApiBase
{
    private HttpClient $http_client;
    private array $url_parameters;
    private string $base_url;

    public function token(string $token): self
    {
        $this->url_parameters['token'] = $token;
        return $this;
    }

    public function getBaseUrl(): string
    {
        return $this->base_url;
    }

    public function setBaseUrl(string $url): self
    {
        $this->base_url = $url;
        return $this;
    }

    public function asJson(): self
    {
        $this->url_parameters['f'] = 'json';
        return $this;
    }

    public function asPjson(): self
    {
        $this->url_parameters['f'] = 'pjson';
        return $this;
    }
}
