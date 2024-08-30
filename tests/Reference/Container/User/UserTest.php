<?php
declare(strict_types=1);

namespace Tests\Reference\Container\User;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tests\Responses\UserResponse;
use Trukes\ThreadsApiPhpClient\Reference\Container\User\User;
use Trukes\ThreadsApiPhpClient\Transporter\TransporterInterface;
use Trukes\ThreadsApiPhpClient\ValueObject\Payload;
use Trukes\ThreadsApiPhpClient\ValueObject\Response;

final class UserTest extends TestCase
{
    protected TransporterInterface $transporter;
    protected User $user;

    #[DataProvider('dataProviderUserThreads')]
    public function testReplyManagementUserThreads(
        string   $threads_user_id,
        Payload  $payload,
        Response $response,
        ?string  $fields = null,
        ?string  $since = null,
        ?string  $until = null,
        ?int     $limit = null,
        ?string  $before = null,
        ?string  $after = null
    ): void
    {
        $this->transporter
            ->expects(self::once())
            ->method('request')
            ->with($payload)
            ->willReturn($response);

        self::assertEquals(
            $response,
            $this->user->threads(
                $threads_user_id,
                $fields,
                $since,
                $until,
                $limit,
                $before,
                $after
            )
        );
    }

    public static function dataProviderUserThreads(): array
    {
        return [
            'user_thread' => [
                'thread-user-1',
                Payload::create(
                    method: TransporterInterface::GET,
                    uri: 'thread-user-1/threads',
                    queryParameters: [
                        'fields' => 'fields',
                        'since' => 'since',
                        'until' => 'until',
                        'limit' => 5,
                        'before' => 'before',
                        'after' => 'after',
                    ]
                ),
                Response::from(json_decode(UserResponse::THREADS_USER_FULL_RESPONSE, true)),
                'fields',
                'since',
                'until',
                5,
                'before',
                'after',
            ],
            'replies_thread_with_null_values' => [
                'thread-user-1',
                Payload::create(
                    method: TransporterInterface::GET,
                    uri: 'thread-user-1/threads',
                ),
                Response::from(json_decode(UserResponse::THREADS_USER_FULL_RESPONSE, true))

            ]
        ];
    }

    #[DataProvider('dataProviderPublishLimit')]
    public function testUserPublishLimit(
        string   $threads_media_id,
        Payload  $payload,
        Response $response,
        ?string  $fields = null,
    ): void
    {
        $this->transporter
            ->expects(self::once())
            ->method('request')
            ->with($payload)
            ->willReturn($response);

        self::assertEquals(
            $response,
            $this->user->publishLimit(
                $threads_media_id,
                $fields,
            )
        );
    }

    public static function dataProviderPublishLimit(): array
    {
        return [
            'user_thread' => [
                'thread-media-1',
                Payload::create(
                    method: TransporterInterface::GET,
                    uri: 'thread-media-1/threads_publishing_limit',
                    queryParameters: [
                        'fields' => 'status',
                    ]
                ),
                Response::from(json_decode(UserResponse::THREADS_USER_PUBLISH_LIMIT_RESPONSE, true)),
                'status',
            ],
            'user_thread_with_null_values' => [
                'thread-media-1',
                Payload::create(
                    method: TransporterInterface::GET,
                    uri: 'thread-media-1/threads_publishing_limit',
                ),
                Response::from(json_decode(UserResponse::THREADS_USER_PUBLISH_LIMIT_RESPONSE, true))
            ]
        ];
    }



    #[DataProvider('dataProviderProfile')]
    public function testUserProfile(
        string   $threads_media_id,
        Payload  $payload,
        Response $response,
        ?string  $fields = null,
    ): void
    {
        $this->transporter
            ->expects(self::once())
            ->method('request')
            ->with($payload)
            ->willReturn($response);

        self::assertEquals(
            $response,
            $this->user->profile(
                $threads_media_id,
                $fields,
            )
        );
    }

    public static function dataProviderProfile(): array
    {
        return [
            'user_thread' => [
                'thread-media-1',
                Payload::create(
                    method: TransporterInterface::GET,
                    uri: 'thread-media-1',
                    queryParameters: [
                        'fields' => 'status',
                    ]
                ),
                Response::from(json_decode(UserResponse::THREADS_USER_PROFILE_RESPONSE, true)),
                'status',
            ],
            'user_thread_with_null_values' => [
                'thread-media-1',
                Payload::create(
                    method: TransporterInterface::GET,
                    uri: 'thread-media-1',
                ),
                Response::from(json_decode(UserResponse::THREADS_USER_PROFILE_RESPONSE, true))
            ]
        ];
    }


    #[DataProvider('dataProviderUserReplies')]
    public function testUserRepliesThreads(
        string   $threads_user_id,
        Payload  $payload,
        Response $response,
        ?string  $fields = null,
        ?string  $since = null,
        ?string  $until = null,
        ?int     $limit = null,
        ?string  $before = null,
        ?string  $after = null
    ): void
    {
        $this->transporter
            ->expects(self::once())
            ->method('request')
            ->with($payload)
            ->willReturn($response);

        self::assertEquals(
            $response,
            $this->user->replies(
                $threads_user_id,
                $fields,
                $since,
                $until,
                $limit,
                $before,
                $after
            )
        );
    }

    public static function dataProviderUserReplies(): array
    {
        return [
            'user_thread' => [
                'thread-user-1',
                Payload::create(
                    method: TransporterInterface::GET,
                    uri: 'thread-user-1/replies',
                    queryParameters: [
                        'fields' => 'fields',
                        'since' => 'since',
                        'until' => 'until',
                        'limit' => 5,
                        'before' => 'before',
                        'after' => 'after',
                    ]
                ),
                Response::from(json_decode(UserResponse::THREADS_USER_REPLIES_RESPONSE, true)),
                'fields',
                'since',
                'until',
                5,
                'before',
                'after',
            ],
            'replies_thread_with_null_values' => [
                'thread-user-1',
                Payload::create(
                    method: TransporterInterface::GET,
                    uri: 'thread-user-1/replies',
                ),
                Response::from(json_decode(UserResponse::THREADS_USER_REPLIES_RESPONSE, true))
            ]
        ];
    }

    protected function setUp(): void
    {
        $this->transporter = $this->createMock(TransporterInterface::class);
        $this->user = new User($this->transporter);
    }
}