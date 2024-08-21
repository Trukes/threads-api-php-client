<?php
declare(strict_types=1);

namespace Trukes\ThreadsApiPhpClient\Feature\ReplyManagement\DTO;

use Trukes\ThreadsApiPhpClient\DTO\Response;
use Trukes\ThreadsApiPhpClient\Service\FromResponseInterface;

final class HideReplies implements FromResponseInterface
{
    private function __construct(public readonly ?bool $success)
    {
    }

    public static function fromResponse(Response $response): FromResponseInterface
    {
        return new self(array_key_exists('success', $response->data()) ? (bool) $response->data()['success'] : null);
    }
}