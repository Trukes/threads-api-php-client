<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Trukes\ThreadsApiPhpClient\Client;
use Trukes\ThreadsApiPhpClient\DTO\Config;
use Trukes\ThreadsApiPhpClient\Threads;

final class ThreadsTest extends TestCase
{
    public function testThreadsClient(): void
    {
        self::assertInstanceOf(Client::class, Threads::client('access-token'));
    }

    public function testThreadsFactory(): void
    {
        self::assertInstanceOf(
            Client::class,
            Threads::factory()
            ->withHttpClient($this->createMock(ClientInterface::class))
            ->withConfig(new Config())
            ->withAccessToken('access-token')
            ->make());
    }
}