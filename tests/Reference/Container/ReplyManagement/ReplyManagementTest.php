<?php
declare(strict_types=1);

namespace Tests\Reference\Container\ReplyManagement;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tests\Responses\ReplyManagementResponse;
use Trukes\ThreadsApiPhpClient\Reference\Container\ReplyManagement\ReplyManagement;
use Trukes\ThreadsApiPhpClient\Transporter\TransporterInterface;
use Trukes\ThreadsApiPhpClient\ValueObject\Payload;
use Trukes\ThreadsApiPhpClient\ValueObject\Response;

final class ReplyManagementTest extends TestCase
{

    protected TransporterInterface $transporter;
    protected ReplyManagement $replyManagement;

    #[DataProvider('dataProviderThreadsReplies')]
    public function testReplyManagementThreadsReplies(
        string   $threads_media_id,
        Payload  $payload,
        Response $response,
        ?string  $fields = null,
        ?bool    $reverse = null,
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
            $this->replyManagement->replies(
                $threads_media_id,
                $fields,
                $reverse,
                $before,
                $after
            )
        );
    }

    public static function dataProviderThreadsReplies(): array
    {
        return [
            'replies_thread' => [
                'thread-media-1',
                Payload::create(
                    method: TransporterInterface::GET,
                    uri: 'thread-media-1/replies',
                    queryParameters: [
                        'fields' => 'status',
                        'reverse' => true,
                        'before' => 'hash_before',
                        'after' => 'hash_after',
                    ]
                ),
                Response::from(json_decode(ReplyManagementResponse::THREADS_REPLIES_FULL_RESPONSE, true)),
                'status',
                true,
                'hash_before',
                'hash_after',
            ],
            'replies_thread_with_null_values' => [
                'thread-media-1',
                Payload::create(
                    method: TransporterInterface::GET,
                    uri: 'thread-media-1/replies',
                ),
                Response::from(json_decode(ReplyManagementResponse::THREADS_REPLIES_FULL_RESPONSE, true))

            ]
        ];
    }

    #[DataProvider('dataProviderConversation')]
    public function testReplyManagementConversation(
        string   $threads_media_id,
        Payload  $payload,
        Response $response,
        ?string  $fields = null,
        ?bool    $reverse = null,
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
            $this->replyManagement->conversation(
                $threads_media_id,
                $fields,
                $reverse,
                $before,
                $after
            )
        );
    }

    public static function dataProviderConversation(): array
    {
        return [
            'conversation_thread' => [
                'thread-media-1',
                Payload::create(
                    method: TransporterInterface::GET,
                    uri: 'thread-media-1/conversation',
                    queryParameters: [
                        'fields' => 'status',
                        'reverse' => true,
                        'before' => 'hash_before',
                        'after' => 'hash_after',
                    ]
                ),
                Response::from(json_decode(ReplyManagementResponse::THREADS_CONVERSATION_FULL_RESPONSE, true)),
                'status',
                true,
                'hash_before',
                'hash_after',
            ],
            'replies_thread_with_null_values' => [
                'thread-media-1',
                Payload::create(
                    method: TransporterInterface::GET,
                    uri: 'thread-media-1/conversation',
                ),
                Response::from(json_decode(ReplyManagementResponse::THREADS_CONVERSATION_FULL_RESPONSE, true))

            ]
        ];
    }

    #[DataProvider('dataProviderManageReply')]
    public function testReplyManagementManageReply(
        string   $threads_reply_id,
        Payload  $payload,
        Response $response,
        ?bool    $hide = null,
    ): void
    {
        $this->transporter
            ->expects(self::once())
            ->method('request')
            ->with($payload)
            ->willReturn($response);

        self::assertEquals(
            $response,
            $this->replyManagement->manageReply(
                $threads_reply_id,
                $hide,
            )
        );
    }

    public static function dataProviderManageReply(): array
    {
        return [
            'manage_reply_thread' => [
                'thread-reply-1',
                Payload::create(
                    method: TransporterInterface::POST,
                    uri: 'thread-reply-1/manage_reply',
                    bodyForm: [
                        'hide' => true,
                    ]
                )
                    ->withAccessTokenOnQueryParams(false)
                    ->withAccessTokenOnBodyForm(true),
                Response::from(json_decode(ReplyManagementResponse::THREADS_HIDE_REPLIES_FULL_RESPONSE, true)),
                true,
            ],
            'manage_reply_thread_with_null_values' => [
                'thread-media-1',
                Payload::create(
                    method: TransporterInterface::POST,
                    uri: 'thread-media-1/manage_reply',
                )
                    ->withAccessTokenOnQueryParams(false)
                    ->withAccessTokenOnBodyForm(true),
                Response::from(json_decode(ReplyManagementResponse::THREADS_HIDE_REPLIES_FULL_RESPONSE, true))
            ]
        ];
    }

    protected function setUp(): void
    {
        $this->transporter = $this->createMock(TransporterInterface::class);
        $this->replyManagement = new ReplyManagement($this->transporter);
    }
}