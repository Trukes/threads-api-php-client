<?php
declare(strict_types=1);

namespace Trukes\ThreadsApiPhpClient\Feature\Insights;

use Trukes\ThreadsApiPhpClient\DTO\Payload;
use Trukes\ThreadsApiPhpClient\Feature\Insights\DTO\Metrics;
use Trukes\ThreadsApiPhpClient\TransporterInterface;
use Trukes\ThreadsApiPhpClient\TransporterTrait;

final class Insights implements InsightsInterface
{
    use TransporterTrait;

    public function mediaInsights(string $threadsMediaId, array $metric): Metrics
    {
        $response = Metrics::fromResponse(
            $this->transporter->request(
                Payload::create(
                    method: TransporterInterface::GET,
                    uri: sprintf('%s/insights', $threadsMediaId),
                    bodyForm: ['metric' => implode(',', $metric)]
                )
                    ->withAccessTokenOnQueryParams(false)
                    ->withAccessTokenOnBodyForm(true)
            )
        );

        assert($response instanceof Metrics);

        return $response;
    }

    public function userInsights(string $threadsUserId, array $metric, array $formFields): Metrics
    {
        $response = Metrics::fromResponse(
            $this->transporter->request(
                Payload::create(
                    method: TransporterInterface::GET,
                    uri: sprintf('%s/threads_insights', $threadsUserId),
                    bodyForm: [
                        ...$formFields,
                        'metric' => implode(',', $metric)
                    ],
                )
                    ->withAccessTokenOnQueryParams(false)
                    ->withAccessTokenOnBodyForm(true)
            )
        );

        assert($response instanceof Metrics);

        return $response;
    }
}