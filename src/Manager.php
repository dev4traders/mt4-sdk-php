<?php

namespace D4T\MT4Sdk;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use D4T\MT4Sdk\Actions\ManagesAccounts;
use D4T\MT4Sdk\Actions\ManagesTrades;
use D4T\MT4Sdk\Actions\ManagesSymbols;

class Mailcoach
{
    use MakesHttpRequests;
    use ManagesAccounts;
    use ManagesTrades;
    use ManagesSymbols;

    public function __construct(
        public string $apiToken,
        public string $apiEndpoint,
        public ?ClientInterface $client = null
    ) {
        $this->client ??= new Client([
            'http_errors' => false,
            'base_uri' => $this->apiEndpoint.'/',
            'headers' => [
                'Authorization' => "Bearer {$this->apiToken}",
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    public function apiToken(): string
    {
        return $this->apiToken;
    }

    public function endpoint(): string
    {
        return $this->mailcoachEndpoint;
    }
}
