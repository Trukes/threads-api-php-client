<?php
declare(strict_types=1);

namespace Trukes\ThreadsApiPhpClient\Feature\ReplyManagement\DTO;

use Trukes\ThreadsApiPhpClient\DTO\Response;
use Trukes\ThreadsApiPhpClient\Service\FromResponseInterface;

final class MediaContainer implements FromResponseInterface
{
    private function __construct(public readonly ?int $id)
    {
    }

    public static function fromResponse(Response $response): FromResponseInterface
    {
        return new self(array_key_exists('id', $response->data()) ? (int) $response->data()['id'] : null);
    }
}