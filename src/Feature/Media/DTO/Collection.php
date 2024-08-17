<?php
declare(strict_types=1);

namespace Trukes\ThreadsApiPhpClient\Feature\Media\DTO;

use Trukes\ThreadsApiPhpClient\DTO\Response;
use Trukes\ThreadsApiPhpClient\Service\FromResponseInterface;
use Exception;

final class Collection implements FromResponseInterface
{
    protected array $data = [];

    private function __construct(private readonly Paging $pagination)
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

        $collection = new self($paging);
        foreach ($data as $item) {
            $collection->append(Item::fromArray($item));
        }

        return $collection;
    }

    public function append(Item $media): self
    {
        $this->data[] = $media;

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