<?php

namespace Trukes\ThreadsApiPhpClient\Feature;

use Trukes\ThreadsApiPhpClient\DTO\Response;

interface PostsInterface
{
    public function createMediaContainer(string $threadsUserId, array $data): Response;
    public function publishMediaContainer(string $threadsUserId, array $data): Response;
}
