<?php
declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use Trukes\ThreadsApiPhpClient\Reference\Container\Insights\Insights;
use Trukes\ThreadsApiPhpClient\Reference\Container\Media\Media;
use Trukes\ThreadsApiPhpClient\Reference\Container\Publish\Publish;
use Trukes\ThreadsApiPhpClient\Reference\Container\ReplyManagement\ReplyManagement;
use Trukes\ThreadsApiPhpClient\Reference\Container\User\User;
use Trukes\ThreadsApiPhpClient\Threads;

final class ClientTest extends TestCase
{
    public function testClient(): void
    {
        $client = Threads::client('access-token-1');

        self::assertInstanceOf(Publish::class, $client->publish());
        self::assertInstanceOf(Media::class, $client->media());
        self::assertInstanceOf(ReplyManagement::class, $client->replyManagement());
        self::assertInstanceOf(User::class, $client->user());
        self::assertInstanceOf(Insights::class, $client->insights());
    }
}