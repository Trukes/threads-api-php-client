<?php
declare(strict_types=1);

namespace Trukes\ThreadsApiPhpClient\Service\Paging;

use Trukes\ThreadsApiPhpClient\DTO\Response;
use Trukes\ThreadsApiPhpClient\Service\FromResponseInterface;

final class Paging implements FromResponseInterface
{
    private Cursor $cursor;

    public function __construct(?string $before, ?string $after)
    {
        $this->cursor = new Cursor($before, $after);
    }

    public static function fromResponse(Response $response): FromResponseInterface
    {
        $paging = $response->data()['paging']['cursors'];

        return new self($paging['before'], $paging['after']);
    }

    public function getCursor(): Cursor
    {
        return $this->cursor;
    }
}