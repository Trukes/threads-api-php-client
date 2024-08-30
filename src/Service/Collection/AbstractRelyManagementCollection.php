<?php
declare(strict_types=1);

namespace Trukes\ThreadsApiPhpClient\Service\Collection;

use Trukes\ThreadsApiPhpClient\ValueObject\Response;
use Trukes\ThreadsApiPhpClient\Service\FromResponseInterface;
use Trukes\ThreadsApiPhpClient\Service\Paging\Paging;
use Exception;

abstract class AbstractRelyManagementCollection extends AbstractCollection implements FromResponseInterface
{
    protected function __construct(private readonly Paging $pagination)
    {
        parent::__construct();
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

    public function getPagination(): Paging
    {
        return $this->pagination;
    }
}