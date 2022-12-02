<?php

namespace Tests;

use D4T\MT4Sdk\Exceptions\FailedActionException;
use D4T\MT4Sdk\Exceptions\NotFoundException;
use D4T\MT4Sdk\Manager;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Illuminate\Validation\ValidationException;
use Mockery;
use PHPUnit\Framework\TestCase;

class MT4SdkTest extends TestCase
{

    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function test_ping()
    {
        $manager = new Manager($_ENV['MT4_API_TOKEN'], $_ENV['MT4_API_ENDPOINT'], $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('GET', 'ping', [])->andReturn(
            new Response(200, [])
        );

        $this->assertNotEmpty(1, $manager->ping());
    }

    public function test_getting_accounts()
    {
        $manager = new Manager($_ENV['MT4_API_TOKEN'], $_ENV['MT4_API_ENDPOINT'], $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('GET', 'accounts', [])->andReturn(
            new Response(200, [], '{"users": [{"key": "value"}]}')
        );

        $this->assertCount(1, $manager->getAccounts());
    }

    public function test_updating_account()
    {
        $manager = new Manager($_ENV['MT4_API_TOKEN'], $_ENV['MT4_API_ENDPOINT'], $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('PUT', 'account/update', [
            'json' => ['name' => 'test'],
        ])->andReturn(
            new Response(200, [], '{"name": "test"}')
        );

        $this->assertSame(['foo.com'], $manager->updateAccount(123, [
            'name' => 'test',
        ])->account);
    }

    public function test_handling_validation_errors()
    {
        $manager = new Manager($_ENV['MT4_API_TOKEN'], $_ENV['MT4_API_ENDPOINT'], $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('PUT', 'account/update', [])->andReturn(
            new Response(422, [], '{"name": ["The name is required."]}')
        );

        try {
            $manager->updateAccount(123, []);
        } catch (ValidationException $e) {
        }

        $this->assertEquals(['name' => ['The name is required.']], $e->errors());
    }

    public function test_handling_404_errors()
    {
        $this->expectException(NotFoundException::class);

        $manager = new Manager($_ENV['MT4_API_TOKEN'], $_ENV['MT4_API_ENDPOINT'], $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('GET', 'account', [])->andReturn(
            new Response(404)
        );

        $manager->getAccounts();
    }

    public function test_handling_failed_action_errors()
    {
        $manager = new Manager($_ENV['MT4_API_TOKEN'], $_ENV['MT4_API_ENDPOINT'], $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('GET', 'account', [])->andReturn(
            new Response(400, [], 'Error!')
        );

        try {
            $manager->getAccounts();
        } catch (FailedActionException $e) {
            $this->assertSame('Error!', $e->getMessage());
        }
    }

}
