<?php
declare(strict_types=1);

namespace Trukes\ThreadsApiPhpClient\Reference\Container\Insights;

use Trukes\ThreadsApiPhpClient\DTO\Response;

interface InsightsInterface
{
    // GET /{threads-media-id}/insights
    public function insights(string $threads_media_id, string $metric): Response;

    //GET /{threads-user-id}/threads_insights
    public function threadsInsights(string $threads_user_id, string $metric, ?string $since = null, ?string $until = null): Response;
}