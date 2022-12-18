<?php

namespace D4T\MT4Sdk;

use D4T\MT4Sdk\Requests\TerminalAccountCreateRequest;
use D4T\MT4Sdk\Resources\TerminalAccountCredentails;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;

class Terminal
{
    use MakesHttpRequests;

    public function __construct(
        public string $apiToken,
        public string $apiEndpoint,
        public ?ClientInterface $client = null
    ) {
        $this->client ??= new Client([
            'http_errors' => false,
            'base_uri' => $this->apiEndpoint.'/terminal/',
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
        return $this->apiEndpoint;
    }

    public function ping() : bool
    {
        $this->get("ping");

        return true;
    }

    public function createAccount(TerminalAccountCreateRequest $request): TerminalAccountCredentails
    {
        $attributes = $this->post('account-create', (array)$request);

        return new TerminalAccountCredentails($attributes, $this);
    }

    public function parseSrv(string $srvFileData): mixed
    {
        // $attributes = $this->post('srv-parse', $srvFileData);

        // return new TerminalAccountCredentails($attributes, $this);

        return null;
    }
}
