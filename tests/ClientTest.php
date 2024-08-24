<?php
declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use Trukes\ThreadsApiPhpClient\Feature\Insights\Insights;
use Trukes\ThreadsApiPhpClient\Feature\Media\Media;
use Trukes\ThreadsApiPhpClient\Feature\Posts\Posts;
use Trukes\ThreadsApiPhpClient\Feature\Profiles\Profiles;
use Trukes\ThreadsApiPhpClient\Feature\ReplyManagement\ReplyManagement;
use Trukes\ThreadsApiPhpClient\Threads;

final class ClientTest extends TestCase
{
    public function testClient(): void
    {
        $client = Threads::client('access-token-1');

        self::assertInstanceOf(Posts::class, $client->posts());
        self::assertInstanceOf(Media::class, $client->media());
        self::assertInstanceOf(Profiles::class, $client->profiles());
        self::assertInstanceOf(ReplyManagement::class, $client->replyManagement());
        self::assertInstanceOf(Insights::class, $client->insights());
    }
}