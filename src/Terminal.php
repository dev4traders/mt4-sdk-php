<?php

namespace D4T\MT4Sdk;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Illuminate\Support\Facades\Http;
use D4T\MT4Sdk\Resources\TerminalAccountCredentails;
use D4T\MT4Sdk\Requests\TerminalAccountCreateRequest;

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

    public function parseSrv(string $srvFileData, string $name): mixed
    {

        $url = $this->apiEndpoint.'/terminal/srv-parse';

        $response = Http::attach(
            'attachment', $srvFileData, $name.'.srv'
        )->post($url);

        if ($response->ok()) {
            return $response->body();
        }

        return null;
    }
}
