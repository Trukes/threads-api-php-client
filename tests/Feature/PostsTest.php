<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Trukes\ThreadsApiPhpClient\DTO\Payload;
use Trukes\ThreadsApiPhpClient\DTO\Response;
use Trukes\ThreadsApiPhpClient\Feature\Posts\Exception\PostsFeatureException;
use Trukes\ThreadsApiPhpClient\Feature\Posts\Posts;
use Trukes\ThreadsApiPhpClient\TransporterInterface;

final class PostsTest extends TestCase
{
    protected TransporterInterface $transporter;

    protected Posts $posts;

    #[DataProvider('dataProviderCreateMediaContainer')]
    public function testPostsCreateMediaContainer(
        string   $threadsUserId,
        array    $data,
        Payload  $payload,
        Response $response
    ): void
    {
        $this->transporter
            ->expects(self::once())
            ->method('request')
            ->with($payload)
            ->willReturn($response);

        $mediaContainer = $this->posts->createMediaContainer($threadsUserId, $data);

        self::assertEquals($response->data()['id'], $mediaContainer->id);
    }

    public static function dataProviderCreateMediaContainer(): array
    {
        return [
            'posts' => [
                'thread-user-id-1',
                ['hello', 'world'],
                Payload::create(
                    TransporterInterface::POST,
                    'thread-user-id-1/threads',
                    ['hello', 'world']
                ),
                Response::from(['id' => 12345])
            ]
        ];
    }

    #[DataProvider('dataProviderPublishMediaContainer')]
    public function testPostsPublishMediaContainer(
        string   $threadsUserId,
        array    $data,
        Payload  $payload,
        Response $response
    ): void
    {
        $this->transporter
            ->expects(self::once())
            ->method('request')
            ->with($payload)
            ->willReturn($response);

        $mediaContainer = $this->posts->publishMediaContainer($threadsUserId, $data);

        self::assertEquals($response->data()['id'], $mediaContainer->id);
    }

    public static function dataProviderPublishMediaContainer(): array
    {
        return [
            'posts' => [
                'thread-user-id-1',
                ['hello', 'world'],
                Payload::create(
                    TransporterInterface::POST,
                    'thread-user-id-1/threads_publish',
                    ['hello', 'world']
                ),
                Response::from(['id' => 12345])
            ]
        ];
    }


    public function testPostException(): void
    {
        $this->transporter
            ->expects(self::once())
            ->method('request')
            ->with(
                Payload::create(
                    TransporterInterface::POST,
                    'thread-user-id-1/threads_publish',
                    ['hello', 'world']
                )
            )
            ->willReturn(Response::from(['no_id_found' => 12345]));

        self::expectException(PostsFeatureException::class);
        self::expectExceptionMessage('Response was invalid. No id found.');

        $this->posts->publishMediaContainer('thread-user-id-1', ['hello', 'world']);
    }


    protected function setUp(): void
    {
        $this->transporter = self::createMock(TransporterInterface::class);
        $this->posts = new Posts($this->transporter);
    }
}