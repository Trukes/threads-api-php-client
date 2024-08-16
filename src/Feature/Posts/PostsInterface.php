<?php

namespace Trukes\ThreadsApiPhpClient\Feature\Posts;

use Trukes\ThreadsApiPhpClient\DTO\Response;
use Trukes\ThreadsApiPhpClient\Feature\Posts\DTO\MediaContainer;

interface PostsInterface
{
    public function createMediaContainer(string $threadsUserId, array $data): MediaContainer;
    public function publishMediaContainer(string $threadsUserId, array $data): MediaContainer;
}
