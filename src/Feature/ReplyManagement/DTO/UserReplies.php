<?php
declare(strict_types=1);

namespace Trukes\ThreadsApiPhpClient\Feature\ReplyManagement\DTO;

use Trukes\ThreadsApiPhpClient\Service\Collection\AbstractCollection;
use Trukes\ThreadsApiPhpClient\Service\Collection\ItemInterface;

final class UserReplies extends AbstractCollection
{
    public function getItem(array $item): ItemInterface
    {
        return UserReply::fromArray($item);
    }
}