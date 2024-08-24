<?php
declare(strict_types=1);

namespace Trukes\ThreadsApiPhpClient\Feature\ReplyManagement\DTO;

use Trukes\ThreadsApiPhpClient\Service\Collection\AbstractRelyManagementCollection;
use Trukes\ThreadsApiPhpClient\Service\Collection\ItemInterface;

final class UserReplies extends AbstractRelyManagementCollection
{
    public function getItem(array $item): ItemInterface
    {
        return UserReply::fromArray($item);
    }
}