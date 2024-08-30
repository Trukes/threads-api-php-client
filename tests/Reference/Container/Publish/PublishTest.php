<?php
declare(strict_types=1);

namespace Tests\Reference\Container\Publish;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tests\Responses\PublishResponse;
use Trukes\ThreadsApiPhpClient\Reference\Container\Publish\Publish;
use Trukes\ThreadsApiPhpClient\Transporter\TransporterInterface;
use Trukes\ThreadsApiPhpClient\ValueObject\Payload;
use Trukes\ThreadsApiPhpClient\ValueObject\Response;

final class PublishTest extends TestCase
{
    protected TransporterInterface $transporter;
    protected Publish $publish;

    #[DataProvider('dataProviderCreate')]
    public function testPublishCreate(
        string   $threads_user_id,
        string   $media_type,
        Payload  $payload,
        Response $response,
        ?string  $text = null,
        ?string  $image_url = null,
        ?string  $video_url = null,
        ?bool    $is_carousel_item = null,
        ?array   $children = null,
        ?string  $reply_to_id = null,
        ?string  $reply_control = null,
        ?array   $allowlisted_country_codes = null,
        ?string  $all_text = null,
    ): void
    {
        $this->transporter
            ->expects(self::once())
            ->method('request')
            ->with($payload)
            ->willReturn($response);

        self::assertEquals(
            $response,
            $this->publish->create(
                $threads_user_id,
                $media_type,
                $text,
                $image_url,
                $video_url,
                $is_carousel_item,
                $children,
                $reply_to_id,
                $reply_control,
                $allowlisted_country_codes,
                $all_text,
            )
        );
    }

    public static function dataProviderCreate(): array
    {
        return [
            'create_thread' => [
                'thread-user-1',
                'TEXT',
                Payload::create(
                    method: TransporterInterface::POST,
                    uri: 'thread-user-1/threads',
                    bodyForm: [
                        'media_type' => 'TEXT',
                        'text' => 'text',
                        'image_url' => 'image_url',
                        'video_url' => 'video_url',
                        'is_carousel_item' => true,
                        'children' => [
                            'test' => 'children'
                        ],
                        'reply_to_id' => 'reply_to_id',
                        'reply_control' => 'everyone',
                        'allowlisted_country_codes' => [
                            'allowlisted_country_codes' => 'test'
                        ],
                        'all_text' => 'all_text',
                    ]
                )
                    ->withAccessTokenOnQueryParams(false)
                    ->withAccessTokenOnBodyForm(true),
                Response::from(json_decode(PublishResponse::THREADS_PUBLISH_CREATE_FULL_RESPONSE, true)),
                'text',
                'image_url',
                'video_url',
                true,
                ['test' => 'children'],
                'reply_to_id',
                'everyone',
                ['allowlisted_country_codes' => 'test'],
                'all_text',
            ],
            'create_thread_with_null_values' => [
                'thread-user-1',
                'TEXT',
                Payload::create(
                    method: TransporterInterface::POST,
                    uri: 'thread-user-1/threads',
                    bodyForm: [
                        'media_type' => 'TEXT',
                    ]
                )
                    ->withAccessTokenOnQueryParams(false)
                    ->withAccessTokenOnBodyForm(true),
                Response::from(json_decode(PublishResponse::THREADS_PUBLISH_CREATE_FULL_RESPONSE, true)),
            ]
        ];
    }

    #[DataProvider('dataProviderPublish')]
    public function testPublish(
        string   $threadsUserId,
        ?string  $creationId,
        Payload  $payload,
        Response $response,
    ): void
    {
        $this->transporter
            ->expects(self::once())
            ->method('request')
            ->with($payload)
            ->willReturn($response);

        self::assertEquals(
            $response,
            $this->publish->publish($threadsUserId, $creationId)
        );
    }

    public static function dataProviderPublish(): array
    {
        return [
            'publish_thread' => [
                'thread-user-1',
                'creation-id-1',
                Payload::create(
                    method: TransporterInterface::POST,
                    uri: 'thread-user-1/threads',
                    bodyForm: ['creation_id' => 'creation-id-1']
                )
                    ->withAccessTokenOnQueryParams(false)
                    ->withAccessTokenOnBodyForm(true),
                Response::from(json_decode(PublishResponse::THREADS_PUBLISH_FULL_RESPONSE, true)),
            ]
        ];
    }

    #[DataProvider('dataProviderStatus')]
    public function testStatus(
        string   $id,
        ?string  $fields,
        Payload  $payload,
        Response $response,
    ): void
    {
        $this->transporter
            ->expects(self::once())
            ->method('request')
            ->with($payload)
            ->willReturn($response);

        self::assertEquals(
            $response,
            $this->publish->status($id, $fields)
        );
    }

    public static function dataProviderStatus(): array
    {
        return [
            'publish_thread' => [
                'thread-container-1',
                'status',
                Payload::create(
                    method: TransporterInterface::GET,
                    uri: 'thread-container-1',
                    queryParameters: ['fields' => 'status']
                ),
                Response::from(json_decode(PublishResponse::THREADS_PUBLISH_STATUS_FULL_RESPONSE, true)),
            ]
        ];
    }

    protected function setUp(): void
    {
        $this->transporter = $this->createMock(TransporterInterface::class);
        $this->publish = new Publish($this->transporter);
    }
}