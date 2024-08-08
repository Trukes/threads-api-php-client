<?php

namespace Trukes\ThreadsApiPhpClient\Feature;


use Psr\Http\Message\ResponseInterface;

interface PostsInterface
{
    public function createMediaContainer(string $threadsUserId, array $data): ResponseInterface;
    public function publishMediaContainer(string $threadsUserId, array $data): ResponseInterface;
}
