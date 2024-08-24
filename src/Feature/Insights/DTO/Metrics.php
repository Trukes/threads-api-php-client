<?php
declare(strict_types=1);

namespace Trukes\ThreadsApiPhpClient\Feature\Insights\DTO;

use Trukes\ThreadsApiPhpClient\Service\Collection\AbstractInsightsCollection;

final class Metrics extends AbstractInsightsCollection
{
    public function getItem(array $item): Metric
    {
        return Metric::fromArray($item);
    }
}