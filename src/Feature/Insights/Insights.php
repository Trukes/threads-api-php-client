<?php
declare(strict_types=1);

namespace Trukes\ThreadsApiPhpClient\Feature\Insights;

use Trukes\ThreadsApiPhpClient\DTO\Payload;
use Trukes\ThreadsApiPhpClient\Feature\Insights\DTO\MediaInsights;
use Trukes\ThreadsApiPhpClient\Feature\Insights\DTO\UserInsights;
use Trukes\ThreadsApiPhpClient\TransporterInterface;
use Trukes\ThreadsApiPhpClient\TransporterTrait;

final class Insights implements InsightsInterface
{
    use TransporterTrait;

    public function mediaInsights(string $threadsMediaId, array $metric): MediaInsights
    {
        $response = MediaInsights::fromResponse(
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

        assert($response instanceof MediaInsights);

        return $response;
    }

    public function userInsights(string $threadsUserId, array $metric, array $queryParameters): UserInsights
    {
        $response = UserInsights::fromResponse(
            $this->transporter->request(
                Payload::create(
                    TransporterInterface::GET,
                    sprintf('%s/threads_insights', $threadsUserId),
                    $queryParameters,
                    ['metric' => implode(',', $metric)]
                )
                    ->withAccessTokenOnQueryParams(false)
                    ->withAccessTokenOnBodyForm(true)
            )
        );

        assert($response instanceof UserInsights);

        return $response;
    }
}