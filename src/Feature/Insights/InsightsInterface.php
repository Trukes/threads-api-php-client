<?php
declare(strict_types=1);

namespace Trukes\ThreadsApiPhpClient\Feature\Insights;

use Trukes\ThreadsApiPhpClient\Feature\Insights\DTO\Metrics;

interface InsightsInterface
{
    public function mediaInsights(string $threadsMediaId, array $metric): Metrics;

    public function userInsights(string $threadsUserId, array $metric, array $formFields): Metrics;
}