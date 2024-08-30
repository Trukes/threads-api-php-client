<?php
declare(strict_types=1);

namespace Tests\Reference\Container\Insights;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tests\Responses\InsightsResponse;
use Trukes\ThreadsApiPhpClient\Reference\Container\Insights\Insights;
use Trukes\ThreadsApiPhpClient\Transporter\TransporterInterface;
use Trukes\ThreadsApiPhpClient\ValueObject\Payload;
use Trukes\ThreadsApiPhpClient\ValueObject\Response;

final class InsightsTest extends TestCase
{
    protected TransporterInterface $transporter;
    protected Insights $insights;

    #[DataProvider('dataProviderInsights')]
    public function testInsights(
        string   $threadsMediaId,
        string    $metric,
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
            $this->insights->insights($threadsMediaId, $metric)
        );
    }

    public static function dataProviderInsights(): array
    {
        return [
            'insights_thread' => [
                'thread-media-1',
                'metric',
                Payload::create(
                    method: TransporterInterface::GET,
                    uri: 'thread-media-1/threads',
                    queryParameters: ['metric' => 'metric'],
                ),
                Response::from(json_decode(InsightsResponse::THREADS_METRICS_FULL_RESPONSE, true)),
            ]
        ];
    }

    #[DataProvider('dataProviderThreadsInsights')]
    public function testThreadsInsights(
        string   $threadsMediaId,
        string    $metric,
        Payload  $payload,
        Response $response,
        ?string  $since = null,
        ?string  $until = null,
    ): void
    {
        $this->transporter
            ->expects(self::once())
            ->method('request')
            ->with($payload)
            ->willReturn($response);

        self::assertEquals(
            $response,
            $this->insights->threadsInsights($threadsMediaId, $metric, $since, $until)
        );
    }

    public static function dataProviderThreadsInsights(): array
    {
        return [
            'insights_thread_all_fields' => [
                'thread-media-1',
                'metric',
                Payload::create(
                    method: TransporterInterface::GET,
                    uri: 'thread-media-1/threads_insights',
                    queryParameters: [
                        'metric' => 'metric',
                        'since' => 'since',
                        'until' => 'until',
                    ],
                ),
                Response::from(json_decode(InsightsResponse::THREADS_METRICS_FULL_RESPONSE, true)),
                'since',
                'until'
            ],
            'insights_thread' => [
                'thread-media-1',
                'metric',
                Payload::create(
                    method: TransporterInterface::GET,
                    uri: 'thread-media-1/threads_insights',
                    queryParameters: ['metric' => 'metric'],
                ),
                Response::from(json_decode(InsightsResponse::THREADS_METRICS_FULL_RESPONSE, true)),
            ]
        ];
    }

    protected function setUp(): void
    {
        $this->transporter = $this->createMock(TransporterInterface::class);
        $this->insights = new Insights($this->transporter);
    }
}