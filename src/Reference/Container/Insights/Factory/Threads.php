<?php
declare(strict_types=1);

namespace Trukes\ThreadsApiPhpClient\Reference\Container\Insights\Factory;

use Trukes\ThreadsApiPhpClient\Reference\Shared\AbstractItemFactory;

final class Threads extends AbstractItemFactory
{
    private string $metric;

    public function withMetric(string $metric): self
    {
        $this->metric = $metric;

        return $this;
    }

    public function toParams(): array
    {
        return [
            'metric' => $this->metric
        ];
    }
}