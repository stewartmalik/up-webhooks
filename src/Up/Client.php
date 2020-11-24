<?php

declare(strict_types=1);

namespace App\Up;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class Client
{
    private HttpClientInterface $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function ping()
    {
        return $this->httpClient->request('GET', 'util/ping')->toArray();
    }

    public function listWebhooks()
    {
        return $this->httpClient->request('GET', 'webhooks')->toArray();
    }

    public function createWebhook(string $url, string $description = null)
    {
        return $this->httpClient->request('POST', 'webhooks', [
            'json' => [
                'data' => [
                    'attributes' => [
                        'url' => $url,
                        'description' => $description
                    ]
                ]
            ]
        ])->toArray();
    }

    public function deleteWebhook(string $id)
    {
        return $this->httpClient->request('DELETE', "webhooks/$id");
    }

    public function pingWebhook(string $id)
    {
        return $this->httpClient->request('POST', "webhooks/$id/ping")->toArray();
    }
}