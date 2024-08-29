<?php
declare(strict_types=1);

namespace Tests\Reference\Container\Media;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tests\Responses\MediaResponse;
use Trukes\ThreadsApiPhpClient\DTO\Payload;
use Trukes\ThreadsApiPhpClient\DTO\Response;
use Trukes\ThreadsApiPhpClient\Reference\Container\Media\Media;
use Trukes\ThreadsApiPhpClient\TransporterInterface;

final class MediaTest extends TestCase
{
    protected TransporterInterface $transporter;
    protected Media $media;

    #[DataProvider('dataProviderMedia')]
    public function testInsights(
        string   $threadsMediaId,
        string   $fields,
        Payload  $payload,
        Response $response
    ): void
    {
        $this->transporter
            ->expects(self::once())
            ->method('request')
            ->with($payload)
            ->willReturn($response);

        self::assertEquals(
            $response,
            $this->media->mediaObject($threadsMediaId, $fields)
        );
    }

    public static function dataProviderMedia(): array
    {
        return [
            'media_thread' => [
                'thread-media-1',
                'metric',
                Payload::create(
                    method: TransporterInterface::GET,
                    uri: 'thread-media-1',
                    queryParameters: ['fields' => 'metric'],
                ),
                Response::from(json_decode(MediaResponse::THREADS_MEDIA_FULL_RESPONSE, true)),
            ]
        ];
    }

    protected function setUp(): void
    {
        $this->transporter = $this->createMock(TransporterInterface::class);
        $this->media = new Media($this->transporter);
    }
}