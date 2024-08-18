<?php
declare(strict_types=1);

namespace Trukes\ThreadsApiPhpClient\Service\Collection;

use Trukes\ThreadsApiPhpClient\DTO\Response;
use Trukes\ThreadsApiPhpClient\Service\FromResponseInterface;
use Trukes\ThreadsApiPhpClient\Service\Paging\Paging;
use Exception;

abstract class AbstractCollection implements FromResponseInterface
{
    protected array $data = [];

    protected function __construct(private readonly Paging $pagination)
    {
    }

    /**
     * @throws Exception
     */
    public static function fromResponse(Response $response): self
    {
        $paging = Paging::fromResponse($response);
        assert($paging instanceof Paging);

        $data = $response->data()['data'];

        $collection = new static($paging);
        foreach ($data as $item) {
            $collection->append($collection->getItem($item));
        }

        return $collection;
    }

    abstract public function getItem(array $item): ItemInterface;

    public function append(ItemInterface $item): self
    {
        $this->data[] = $item;

        return $this;
    }

    public function getPagination(): Paging
    {
        return $this->pagination;
    }

    public function getData(): array
    {
        return $this->data;
    }
}