<?php

use D4T\MT4Sdk\Manager;

it('can new up sdk', function () {
    $manager = new Manager('fake-token', 'fake-uri');

    expect($manager)->toBeInstanceOf(Manager::class);

    expect($manager->apiToken())->toBe('fake-token');
    expect($manager->endpoint())->toBe('fake-uri');
});
