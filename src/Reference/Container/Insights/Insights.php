<?php
declare(strict_types=1);

namespace Trukes\ThreadsApiPhpClient\Reference\Container\Insights;

use Trukes\ThreadsApiPhpClient\Reference\Container\Insights\Factory\Threads;
use Trukes\ThreadsApiPhpClient\Reference\Container\Insights\Factory\ThreadsInsights;
use Trukes\ThreadsApiPhpClient\Transporter\TransporterInterface;
use Trukes\ThreadsApiPhpClient\Transporter\TransporterTrait;
use Trukes\ThreadsApiPhpClient\ValueObject\Payload;
use Trukes\ThreadsApiPhpClient\ValueObject\Response;

final class Insights implements InsightsInterface
{
    use TransporterTrait;

    public function insights(string $threads_media_id, string $metric): Response
    {
        return $this->transporter->request(
            Payload::create(
                TransporterInterface::GET,
                sprintf('%s/threads', $threads_media_id),
                Threads::create()
                    ->withMetric($metric)
                    ->toArray()
            )
        );
    }

    public function threadsInsights(string $threads_user_id, string $metric, ?string $since = null, ?string $until = null): Response
    {
        return $this->transporter->request(
            Payload::create(
                TransporterInterface::GET,
                sprintf('%s/threads_insights', $threads_user_id),
                ThreadsInsights::create()
                    ->withMetric($metric)
                    ->withSince($since)
                    ->withUntil($until)
                    ->toArray()
            )
        );
    }
}