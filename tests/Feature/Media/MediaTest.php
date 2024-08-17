<?php

namespace Tests\Feature\Media;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Trukes\ThreadsApiPhpClient\DTO\Payload;
use Trukes\ThreadsApiPhpClient\DTO\Response;
use Trukes\ThreadsApiPhpClient\Feature\Media\DTO\Item;
use Trukes\ThreadsApiPhpClient\Feature\Media\Exception\MediaFeatureException;
use Trukes\ThreadsApiPhpClient\Feature\Media\Media;
use Trukes\ThreadsApiPhpClient\TransporterInterface;

final class MediaTest extends TestCase
{
    protected TransporterInterface $transporter;

    protected Media $media;

    #[DataProvider('dataProviderMedia')]
    public function testMediaListAllUsers(
        string   $threadsUserId,
        array    $fields,
        array    $queryParameters,
        Payload  $payload,
        Response $response,
        array    $expectedItem
    ): void
    {
        $this->transporter
            ->expects(self::once())
            ->method('request')
            ->with($payload)
            ->willReturn($response);

        $list = $this->media->listAllUsersThreads($threadsUserId, $fields, $queryParameters);

        self::assertEquals(
            'AFTER_CURSOR',
            $list->getPagination()->getCursor()->after
        );

        self::assertEquals(
            'BEFORE_CURSOR',
            $list->getPagination()->getCursor()->before
        );

        self::assertEquals(
            [Item::fromArray($expectedItem)],
            $list->getData()
        );
    }

    public static function dataProviderMedia(): array
    {
        return [
            'media' => [
                'thread-user-id-1',
                [
                    'id',
                    'media_product_type',
                    'media_type',
                    'media_url',
                    'permalink',
                    'owner',
                    'username',
                    'text',
                    'timestamp',
                    'shortcode',
                    'thumbnail_url',
                    'children',
                    'is_quote_post'
                ],
                ['since' => '2023-10-15', 'until' => '2024-10-15'],
                Payload::create(
                    TransporterInterface::GET,
                    'thread-user-id-1/threads',
                    [
                        'since' => '2023-10-15',
                        'until' => '2024-10-15',
                        'fields' => 'id,media_product_type,media_type,media_url,permalink,owner,username,text,timestamp,shortcode,thumbnail_url,children,is_quote_post'
                    ]
                ),
                Response::from(
                    json_decode(
                        '{
  "data": [
    {
      "id": "1234567",
      "media_product_type": "THREADS",
      "media_type": "TEXT_POST",
      "permalink": "https://www.threads.net/@threadsapitestuser/post/abcdefg",
      "owner": {
        "id": "1234567"
      },
      "username": "threadsapitestuser",
      "text": "Today Is Monday",
      "timestamp": "2023-10-17T05:42:03+0000",
      "shortcode": "abcdefg",
      "is_quote_post": false
    }
  ],
  "paging": {
    "cursors": {
      "before": "BEFORE_CURSOR",
      "after": "AFTER_CURSOR"
    }
  }
}'
                        , true),

                ),
                [
                    'id' => '1234567',
                    'media_product_type' => 'THREADS',
                    'media_type' => 'TEXT_POST',
                    'permalink' => 'https://www.threads.net/@threadsapitestuser/post/abcdefg',
                    'owner' => [
                        'id' => '1234567'
                    ],
                    'username' => 'threadsapitestuser',
                    'text' => 'Today Is Monday',
                    'timestamp' => '2023-10-17T05:42:03+0000',
                    'shortcode' => 'abcdefg',
                    'is_quote_post' => false
                ]
            ]
        ];
    }


    #[DataProvider('dataProviderSingleMedia')]
    public function testMediaSingle(
        string   $threadsUserId,
        array    $fields,
        array    $queryParameters,
        Payload  $payload,
        Response $response,
        array    $expectedItem
    ): void
    {
        $this->transporter
            ->expects(self::once())
            ->method('request')
            ->with($payload)
            ->willReturn($response);

        $list = $this->media->singleThreadsMedia($threadsUserId, $fields, $queryParameters);


        self::assertEquals(
            Item::fromArray($expectedItem),
            $list
        );
    }

    public static function dataProviderSingleMedia(): array
    {
        return [
            'media' => [
                'thread-user-id-1',
                [
                    'id',
                    'media_product_type',
                    'media_type',
                    'media_url',
                    'permalink',
                    'owner',
                    'username',
                    'text',
                    'timestamp',
                    'shortcode',
                    'thumbnail_url',
                    'children',
                    'is_quote_post'
                ],
                ['since' => '2023-10-15', 'until' => '2024-10-15'],
                Payload::create(
                    TransporterInterface::GET,
                    'thread-user-id-1',
                    [
                        'since' => '2023-10-15',
                        'until' => '2024-10-15',
                        'fields' => 'id,media_product_type,media_type,media_url,permalink,owner,username,text,timestamp,shortcode,thumbnail_url,children,is_quote_post'
                    ]
                ),
                Response::from(
                    json_decode(
                        '{
      "id": "1234567",
      "media_product_type": "THREADS",
      "media_type": "TEXT_POST",
      "permalink": "https://www.threads.net/@threadsapitestuser/post/abcdefg",
      "owner": {
        "id": "1234567"
      },
      "username": "threadsapitestuser",
      "text": "Today Is Monday",
      "timestamp": "2023-10-17T05:42:03+0000",
      "shortcode": "abcdefg",
      "is_quote_post": false
}'
                        , true),

                ),
                [
                    'id' => '1234567',
                    'media_product_type' => 'THREADS',
                    'media_type' => 'TEXT_POST',
                    'permalink' => 'https://www.threads.net/@threadsapitestuser/post/abcdefg',
                    'owner' => [
                        'id' => '1234567'
                    ],
                    'username' => 'threadsapitestuser',
                    'text' => 'Today Is Monday',
                    'timestamp' => '2023-10-17T05:42:03+0000',
                    'shortcode' => 'abcdefg',
                    'is_quote_post' => false
                ]
            ]
        ];
    }


    protected function setUp(): void
    {
        $this->transporter = self::createMock(TransporterInterface::class);
        $this->media = new Media($this->transporter);
    }
}