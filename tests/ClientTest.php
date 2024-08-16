<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Trukes\ThreadsApiPhpClient\Feature\Posts\Posts;
use Trukes\ThreadsApiPhpClient\Threads;

final class ClientTest extends TestCase
{
    public function testClient(): void
    {
        $client = Threads::client('access-token-1');

        self::assertInstanceOf(Posts::class, $client->posts());
    }
}