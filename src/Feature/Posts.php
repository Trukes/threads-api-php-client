<?php

namespace Trukes\ThreadsApiPhpClient\Feature;

use Psr\Http\Message\ResponseInterface;
use Trukes\ThreadsApiPhpClient\TransporterInterface;
use Trukes\ThreadsApiPhpClient\TransporterTrait;

final class Posts implements PostsInterface
{
    use TransporterTrait;

    private const CREATE_MEDIA_CONTAINER_URI = 'threads';
    private const PUBLISH_MEDIA_CONTAINER_URI = 'threads_publish';

    public function createMediaContainer(string $threadsUserId, array $data): ResponseInterface
    {
        return $this->transporter->request(
            TransporterInterface::POST,
            sprintf('%s/%s', $threadsUserId, self::CREATE_MEDIA_CONTAINER_URI),
            $data
        );
    }

    public function publishMediaContainer(string $threadsUserId, array $data): ResponseInterface
    {
        return $this->transporter->request(
            TransporterInterface::POST,
            sprintf('%s/%s', $threadsUserId, self::PUBLISH_MEDIA_CONTAINER_URI),
            $data
        );
    }
}
