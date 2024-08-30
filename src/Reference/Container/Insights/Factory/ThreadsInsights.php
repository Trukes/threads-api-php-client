<?php
declare(strict_types=1);

namespace Trukes\ThreadsApiPhpClient\Reference\Container\Insights\Factory;

use Trukes\ThreadsApiPhpClient\Reference\Shared\AbstractItemFactory;

final class ThreadsInsights extends AbstractItemFactory
{
    private string $metric;
    private ?string $since = null;
    private ?string $until = null;

    public function withMetric(string $metric): self
    {
        $this->metric = $metric;

        return $this;
    }
    public function withSince(?string $since): self
    {
        $this->since = $since;

        return $this;
    }
    public function withUntil(?string $until): self
    {
        $this->until = $until;

        return $this;
    }

    public function toParams(): array
    {
        return [
            'metric' => $this->metric,
            'since' => $this->since,
            'until' => $this->until,
        ];
    }
}