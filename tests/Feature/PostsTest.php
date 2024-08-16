<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Trukes\ThreadsApiPhpClient\DTO\Payload;
use Trukes\ThreadsApiPhpClient\DTO\Response;
use Trukes\ThreadsApiPhpClient\Feature\Posts;
use Trukes\ThreadsApiPhpClient\TransporterInterface;

final class PostsTest extends TestCase
{
    #[DataProvider('dataProviderCreateMediaContainer')]
    public function testPostsCreateMediaContainer(
        string $threadsUserId,
        array $data,
        Payload $payload,
        Response $response
    ): void
    {
        $transporter = self::createMock(TransporterInterface::class);
        $transporter
            ->expects(self::once())
            ->method('request')
            ->with($payload)
            ->willReturn($response);

        $posts = new Posts($transporter);

        $mediaContainer = $posts->createMediaContainer($threadsUserId, $data);

        self::assertEquals($response->data(), $mediaContainer->data());
    }

    public static function dataProviderCreateMediaContainer(): array
    {
        return [
            'posts' => [
                'thread-user-id-1',
                ['ola', 'mundo'],
                Payload::create(
                    TransporterInterface::POST,
                    'thread-user-id-1/threads',
                    ['ola', 'mundo']
                ),
                Response::from(['id' => 12345])
            ]
        ];
    }

    #[DataProvider('dataProviderPublishMediaContainer')]
    public function testPostsPublishMediaContainer(
        string $threadsUserId,
        array $data,
        Payload $payload,
        Response $response
    ): void
    {
        $transporter = self::createMock(TransporterInterface::class);
        $transporter
            ->expects(self::once())
            ->method('request')
            ->with($payload)
            ->willReturn($response);

        $posts = new Posts($transporter);

        $mediaContainer = $posts->publishMediaContainer($threadsUserId, $data);

        self::assertEquals($response->data(), $mediaContainer->data());
    }

    public static function dataProviderPublishMediaContainer(): array
    {
        return [
            'posts' => [
                'thread-user-id-1',
                ['ola', 'mundo'],
                Payload::create(
                    TransporterInterface::POST,
                    'thread-user-id-1/threads_publish',
                    ['ola', 'mundo']
                ),
                Response::from(['id' => 12345])
            ]
        ];
    }
}