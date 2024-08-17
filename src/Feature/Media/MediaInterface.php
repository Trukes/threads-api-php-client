<?php

namespace Trukes\ThreadsApiPhpClient\Feature\Media;

use Trukes\ThreadsApiPhpClient\Feature\Media\DTO\Collection;
use Trukes\ThreadsApiPhpClient\Feature\Media\DTO\Item;

interface MediaInterface
{
    public function singleThreadsMedia(string $threadsUserId, array $fields, array $queryParams): Item;

    public function listAllUsersThreads(string $threadsUserId, array $fields, array $queryParams): Collection;

}