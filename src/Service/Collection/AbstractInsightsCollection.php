<?php
declare(strict_types=1);

namespace Trukes\ThreadsApiPhpClient\Service\Collection;

use Trukes\ThreadsApiPhpClient\DTO\Response;
use Trukes\ThreadsApiPhpClient\Service\FromResponseInterface;
use Exception;

abstract class AbstractInsightsCollection extends AbstractCollection implements FromResponseInterface
{
    /**
     * @throws Exception
     */
    public static function fromResponse(Response $response): self
    {
        $data = $response->data()['data'];

        $collection = new static();
        foreach ($data as $item) {
            $collection->append($collection->getItem($item));
        }

        return $collection;
    }
}