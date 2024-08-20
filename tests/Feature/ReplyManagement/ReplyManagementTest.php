<?php
declare(strict_types=1);

namespace Tests\Feature\ReplyManagement;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tests\Responses\ReplyManagementResponse;
use Trukes\ThreadsApiPhpClient\DTO\Payload;
use Trukes\ThreadsApiPhpClient\DTO\Response;
use Trukes\ThreadsApiPhpClient\Feature\ReplyManagement\DTO\ThreadsCollectionConversation;
use Trukes\ThreadsApiPhpClient\Feature\ReplyManagement\DTO\ThreadsCollectionReplies;
use Trukes\ThreadsApiPhpClient\Feature\ReplyManagement\ReplyManagement;
use Trukes\ThreadsApiPhpClient\TransporterInterface;

final class ReplyManagementTest extends TestCase
{
    protected TransporterInterface $transporter;
    protected ReplyManagement $replyManagement;

    #[DataProvider('dataProviderThreadsReplies')]
    public function testThreadsReplies(
        string   $mediaId,
        array    $fields,
        array    $queryParameters,
        Payload  $payload,
        Response $response,
    ): void
    {
        $this->transporter
            ->expects(self::once())
            ->method('request')
            ->with($payload)
            ->willReturn($response);

        $threadsReplies = $this->replyManagement->threadReplies($mediaId, $fields, $queryParameters);

        self::assertEquals(
            ThreadsCollectionReplies::fromResponse($response),
            $threadsReplies
        );
    }

    public static function dataProviderThreadsReplies(): array
    {
        return [
            'reply_management_thread_replies' => [
                'thread-media-id-1',
                ReplyManagementResponse::THREADS_REPLIES_FULL_FIELDS,
                ['since' => '2023-10-15', 'until' => '2024-10-15', 'reverse' => true],
                Payload::create(
                    TransporterInterface::GET,
                    'thread-media-id-1/replies',
                    [
                        'since' => '2023-10-15',
                        'until' => '2024-10-15',
                        'fields' => 'id,text,username,permalink,timestamp,media_product_type,media_type,media_url,shortcode,thumbnail_url,children,is_quote_post,has_replies,root_post,replied_to,is_reply,is_reply_owned_by_me,hide_status,reply_audience',
                        'reverse' => true
                    ]
                ),
                Response::from(json_decode(ReplyManagementResponse::THREADS_REPLIES_FULL_RESPONSE, true)),
            ],
            'reply_management_thread_replies_with_some_fields' => [
                'thread-media-id-1',
                ReplyManagementResponse::THREADS_REPLIES_HALF_FIELDS,
                ['since' => '2023-10-15', 'until' => '2024-10-15'],
                Payload::create(
                    TransporterInterface::GET,
                    'thread-media-id-1/replies',
                    [
                        'since' => '2023-10-15',
                        'until' => '2024-10-15',
                        'fields' => 'id,text'
                    ]
                ),
                Response::from(json_decode(ReplyManagementResponse::THREADS_REPLIES_HALF_RESPONSE, true))
            ]
        ];
    }

    #[DataProvider('dataProviderThreadsConversation')]
    public function testThreadsConversation(
        string   $mediaId,
        array    $fields,
        array    $queryParameters,
        Payload  $payload,
        Response $response,
    ): void
    {
        $this->transporter
            ->expects(self::once())
            ->method('request')
            ->with($payload)
            ->willReturn($response);

        $threadsConversation = $this->replyManagement->threadConversation($mediaId, $fields, $queryParameters);

        self::assertEquals(
            ThreadsCollectionConversation::fromResponse($response),
            $threadsConversation
        );
    }

    public static function dataProviderThreadsConversation(): array
    {
        return [
            'reply_management_thread_conversation' => [
                'thread-media-id-1',
                ReplyManagementResponse::THREADS_CONVERSATION_FULL_FIELDS,
                ['since' => '2023-10-15', 'until' => '2024-10-15', 'reverse' => true],
                Payload::create(
                    TransporterInterface::GET,
                    'thread-media-id-1/conversation',
                    [
                        'since' => '2023-10-15',
                        'until' => '2024-10-15',
                        'fields' => 'id,text,timestamp,media_product_type,media_type,shortcode,has_replies,root_post,replied_to,is_reply,hide_status',
                        'reverse' => true
                    ]
                ),
                Response::from(json_decode(ReplyManagementResponse::THREADS_CONVERSATION_FULL_RESPONSE, true)),
            ],
            'reply_management_thread_conversation_with_some_fields' => [
                'thread-media-id-1',
                ReplyManagementResponse::THREADS_CONVERSATION_HALF_FIELDS,
                ['since' => '2023-10-15', 'until' => '2024-10-15'],
                Payload::create(
                    TransporterInterface::GET,
                    'thread-media-id-1/conversation',
                    [
                        'since' => '2023-10-15',
                        'until' => '2024-10-15',
                        'fields' => 'root_post'
                    ]
                ),
                Response::from(json_decode(ReplyManagementResponse::THREADS_CONVERSATION_HALF_RESPONSE, true))
            ]
        ];
    }


    protected function setUp(): void
    {
        $this->transporter = self::createMock(TransporterInterface::class);
        $this->replyManagement = new ReplyManagement($this->transporter);
    }
}