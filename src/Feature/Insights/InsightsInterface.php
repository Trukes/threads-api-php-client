<?php
declare(strict_types=1);

namespace Trukes\ThreadsApiPhpClient\Feature\Insights;

use Trukes\ThreadsApiPhpClient\Feature\Insights\DTO\MediaInsights;
use Trukes\ThreadsApiPhpClient\Feature\Insights\DTO\UserInsights;

interface InsightsInterface
{
    public function mediaInsights(string $threadsMediaId, array $metric): MediaInsights;

    public function userInsights(string $threadsUserId, array $metric, array $queryParameters): UserInsights;
}