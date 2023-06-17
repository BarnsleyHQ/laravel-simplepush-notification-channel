<?php

namespace BarnsleyHQ\SimplePush;

use GuzzleHttp\Client as HttpClient;

class SimplePushClient
{
    const API_BASE_URL = 'https://api.simplepush.io';

    public HttpClient $client;

    public function __construct(?HttpClient $httpClient = null)
    {
        if (! $httpClient) {
            $httpClient = new HttpClient();
        }

        $this->client = $httpClient;
    }

    public static function withClient(?HttpClient $httpClient): self
    {
        return new self($httpClient);
    }

    public function post(string $url, array $data = []): array|null
    {
        $response = $this->client->post(self::API_BASE_URL.$url, $data);

        return json_decode($response->getBody(), true);
    }

    public function get(string $url, array $data = []): array|null
    {
        $url = self::API_BASE_URL.$url;
        if (! empty($data)) {
            $url .= '?'.http_build_query($data);
        }

        $response = $this->client->get($url);

        return json_decode($response->getBody(), true);
    }
}
