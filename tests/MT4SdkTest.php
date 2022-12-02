<?php

namespace Tests;

use D4T\MT4Sdk\Exceptions\FailedActionException;
use D4T\MT4Sdk\Exceptions\InvalidDataException;
use D4T\MT4Sdk\Exceptions\NotFoundException;
use D4T\MT4Sdk\Manager;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Illuminate\Validation\ValidationException;
use Mockery;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

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

        $this->assertTrue($manager->ping(), "Ping succedded");
    }

    public function test_getting_accounts()
    {
        $manager = new Manager($_ENV['MT4_API_TOKEN'], $_ENV['MT4_API_ENDPOINT'], $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('GET', 'users', [])->andReturn(
            new Response(200, [], '')
        );

        $this->assertNotCount(0, $manager->listAccountLogins());
    }

    // public function test_updating_account()
    // {
    //     $manager = new Manager($_ENV['MT4_API_TOKEN'], $_ENV['MT4_API_ENDPOINT'], $http = Mockery::mock(Client::class));

    //     $http->shouldReceive('request')->once()->with('POST', 'user/update/123', [
    //         'json' => ['name' => 'test'],
    //     ])->andReturn(
    //         new Response(200, [], '{"name": "test"}')
    //     );

    //     $this->assertContains('test', $manager->updateAccount(123, [
    //         'name' => 'test',
    //     ])->account);
    // }

    public function test_handling_validation_errors()
    {
        $manager = new Manager($_ENV['MT4_API_TOKEN'], $_ENV['MT4_API_ENDPOINT'], $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('POST', 'user/add', [])->andReturn(
            new Response(422, [], '"The name is required."')
        );

        try {
            $manager->createAccount([]);
        } catch (InvalidDataException $e) {
        }

        $this->assertEquals('The name is required.', $e->getMessage());
    }

    public function test_handling_404_errors()
    {
        $this->expectException(ResourceNotFoundException::class);

        $manager = new Manager($_ENV['MT4_API_TOKEN'], $_ENV['MT4_API_ENDPOINT'], $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('GET', 'user/0', [])->andReturn(
            new Response(404)
        );

        $manager->getAccount(0);
    }

    public function test_handling_failed_action_errors()
    {
        $manager = new Manager($_ENV['MT4_API_TOKEN'], $_ENV['MT4_API_ENDPOINT'], $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('GET', 'user/0', [])->andReturn(
            new Response(400, [], 'Error!')
        );

        try {
            $manager->getAccount(0);
        } catch (FailedActionException $e) {
            $this->assertSame('Error!', $e->getMessage());
        }
    }

}
