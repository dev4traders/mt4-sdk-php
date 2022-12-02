<?php

namespace Tests;

use D4T\MT4Sdk\Manager;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Mockery;
use PHPUnit\Framework\TestCase;

class MT4SDKTest extends TestCase
{

    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function test_making_basic_requests()
    {
        $manager = new Manager($_ENV['MT4_API_TOKEN'], $_ENV['MT4_API_ENDPOINT'], $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('GET', 'accounts', [])->andReturn(
            new Response(200, [], '{"users": [{"key": "value"}]}')
        );

        $this->assertCount(1, $manager->getAccounts());
    }

    public function test_update_account()
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

    // public function test_handling_validation_errors()
    // {
    //     $forge = new Forge('123', $http = Mockery::mock(Client::class));

    //     $http->shouldReceive('request')->once()->with('GET', 'recipes', [])->andReturn(
    //         new Response(422, [], '{"name": ["The name is required."]}')
    //     );

    //     try {
    //         $forge->recipes();
    //     } catch (ValidationException $e) {
    //     }

    //     $this->assertEquals(['name' => ['The name is required.']], $e->errors());
    // }

    // public function test_handling_404_errors()
    // {
    //     $this->expectException(NotFoundException::class);

    //     $forge = new Forge('123', $http = Mockery::mock(Client::class));

    //     $http->shouldReceive('request')->once()->with('GET', 'recipes', [])->andReturn(
    //         new Response(404)
    //     );

    //     $forge->recipes();
    // }

    // public function test_handling_failed_action_errors()
    // {
    //     $forge = new Forge('123', $http = Mockery::mock(Client::class));

    //     $http->shouldReceive('request')->once()->with('GET', 'recipes', [])->andReturn(
    //         new Response(400, [], 'Error!')
    //     );

    //     try {
    //         $forge->recipes();
    //     } catch (FailedActionException $e) {
    //         $this->assertSame('Error!', $e->getMessage());
    //     }
    // }

    // public function testRetryHandlesFalseResultFromClosure()
    // {
    //     $requestMaker = new class()
    //     {
    //         use MakesHttpRequests;
    //     };

    //     try {
    //         $requestMaker->retry(0, function () {
    //             return false;
    //         }, 0);
    //         $this->fail();
    //     } catch (TimeoutException $e) {
    //         $this->assertSame([], $e->output());
    //     }
    // }

    // public function testRetryHandlesNullResultFromClosure()
    // {
    //     $requestMaker = new class()
    //     {
    //         use MakesHttpRequests;
    //     };

    //     try {
    //         $requestMaker->retry(0, function () {
    //             return null;
    //         }, 0);
    //         $this->fail();
    //     } catch (TimeoutException $e) {
    //         $this->assertSame([], $e->output());
    //     }
    // }

    // public function testRetryHandlesFalseyStringResultFromClosure()
    // {
    //     $requestMaker = new class()
    //     {
    //         use MakesHttpRequests;
    //     };

    //     try {
    //         $requestMaker->retry(0, function () {
    //             return '';
    //         }, 0);
    //         $this->fail();
    //     } catch (TimeoutException $e) {
    //         $this->assertSame([''], $e->output());
    //     }
    // }

    // public function testRetryHandlesFalseyNumerResultFromClosure()
    // {
    //     $requestMaker = new class()
    //     {
    //         use MakesHttpRequests;
    //     };

    //     try {
    //         $requestMaker->retry(0, function () {
    //             return 0;
    //         }, 0);
    //         $this->fail();
    //     } catch (TimeoutException $e) {
    //         $this->assertSame([0], $e->output());
    //     }
    // }

    // public function testRetryHandlesFalseyArrayResultFromClosure()
    // {
    //     $requestMaker = new class()
    //     {
    //         use MakesHttpRequests;
    //     };

    //     try {
    //         $requestMaker->retry(0, function () {
    //             return [];
    //         }, 0);
    //         $this->fail();
    //     } catch (TimeoutException $e) {
    //         $this->assertSame([], $e->output());
    //     }
    // }

    // public function testRateLimitExceededWithHeaderSet()
    // {
    //     $forge = new Forge('123', $http = Mockery::mock(Client::class));

    //     $timestamp = strtotime(date('Y-m-d H:i:s'));

    //     $http->shouldReceive('request')->once()->with('GET', 'recipes', [])->andReturn(
    //         new Response(429, [
    //             'x-ratelimit-reset' => $timestamp,
    //         ], 'Too Many Attempts.')
    //     );

    //     try {
    //         $forge->recipes();
    //     } catch (RateLimitExceededException $e) {
    //         $this->assertSame($timestamp, $e->rateLimitResetsAt);
    //     }
    // }

    // public function testRateLimitExceededWithHeaderNotAvailable()
    // {
    //     $forge = new Forge('123', $http = Mockery::mock(Client::class));

    //     $http->shouldReceive('request')->once()->with('GET', 'recipes', [])->andReturn(
    //         new Response(429, [], 'Too Many Attempts.')
    //     );

    //     try {
    //         $forge->recipes();
    //     } catch (RateLimitExceededException $e) {
    //         $this->assertNull($e->rateLimitResetsAt);
    //     }
    // }
}
