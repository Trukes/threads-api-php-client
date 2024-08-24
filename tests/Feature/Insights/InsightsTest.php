<?php
declare(strict_types=1);

namespace Tests\Feature\Insights;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tests\Responses\InsightsResponse;
use Trukes\ThreadsApiPhpClient\DTO\Payload;
use Trukes\ThreadsApiPhpClient\DTO\Response;
use Trukes\ThreadsApiPhpClient\Feature\Insights\DTO\Metrics;
use Trukes\ThreadsApiPhpClient\Feature\Insights\Insights;
use Trukes\ThreadsApiPhpClient\TransporterInterface;

final class InsightsTest extends TestCase
{
    protected TransporterInterface $transporter;
    protected Insights $insights;

    #[DataProvider('dataProviderMedia')]
    public function testMedia(
        string   $threadsMediaId,
        array    $metric,
        Payload  $payload,
        Response $response,
    ): void
    {
        $this->transporter
            ->expects(self::once())
            ->method('request')
            ->with($payload)
            ->willReturn($response);

        $threads = $this->insights->mediaInsights($threadsMediaId, $metric);

        self::assertEquals(
            Metrics::fromResponse($response),
            $threads
        );
    }

    public static function dataProviderMedia(): array
    {
        return [
            'insights_thread' => [
                'thread-media-1',
                InsightsResponse::THREADS_METRIC_FULL_FORM_FIELDS,
                Payload::create(
                    method: TransporterInterface::GET,
                    uri: 'thread-media-1/insights',
                    bodyForm: ['metric' => implode(',', InsightsResponse::THREADS_METRIC_FULL_FORM_FIELDS)]
                )
                    ->withAccessTokenOnQueryParams(false)
                    ->withAccessTokenOnBodyForm(true),
                Response::from(json_decode(InsightsResponse::THREADS_METRICS_FULL_RESPONSE, true)),
            ]
        ];
    }

    #[DataProvider('dataProviderUser')]
    public function testUser(
        string   $threadsMediaId,
        array    $metric,
        array    $formFields,
        Payload  $payload,
        Response $response,
    ): void
    {
        $this->transporter
            ->expects(self::once())
            ->method('request')
            ->with($payload)
            ->willReturn($response);

        $threads = $this->insights->userInsights($threadsMediaId, $metric, $formFields);

        self::assertEquals(
            Metrics::fromResponse($response),
            $threads
        );
    }

    public static function dataProviderUser(): array
    {
        return [
            'insights_thread' => [
                'thread-user-1',
                InsightsResponse::THREADS_METRIC_FULL_FORM_FIELDS,
                InsightsResponse::THREADS_USERS_FULL_FORM_FIELDS,
                Payload::create(
                    method: TransporterInterface::GET,
                    uri: 'thread-user-1/threads_insights',
                    bodyForm: [
                        ...InsightsResponse::THREADS_USERS_FULL_FORM_FIELDS,
                        'metric' => implode(',', InsightsResponse::THREADS_METRIC_FULL_FORM_FIELDS)
                    ]
                )
                    ->withAccessTokenOnQueryParams(false)
                    ->withAccessTokenOnBodyForm(true),
                Response::from(json_decode(InsightsResponse::THREADS_METRICS_FULL_RESPONSE, true)),
            ]
        ];
    }

    protected function setUp(): void
    {
        $this->transporter = self::createMock(TransporterInterface::class);
        $this->insights = new Insights($this->transporter);
    }
}