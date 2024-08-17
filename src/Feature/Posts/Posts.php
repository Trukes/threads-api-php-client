<?php

namespace Trukes\ThreadsApiPhpClient\Feature\Posts;

use Trukes\ThreadsApiPhpClient\DTO\Payload;
use Trukes\ThreadsApiPhpClient\Feature\Posts\DTO\MediaContainer;
use Trukes\ThreadsApiPhpClient\Feature\Posts\Exception\PostsFeatureException;
use Trukes\ThreadsApiPhpClient\TransporterInterface;
use Trukes\ThreadsApiPhpClient\TransporterTrait;

final class Posts implements PostsInterface
{
    use TransporterTrait;

    private const CREATE_MEDIA_CONTAINER_URI = 'threads';
    private const PUBLISH_MEDIA_CONTAINER_URI = 'threads_publish';

    /**
     * @throws PostsFeatureException
     */
    public function createMediaContainer(string $threadsUserId, array $data): MediaContainer
    {
        return
            MediaContainer::fromResponse(
                $this->transporter->request(
                    Payload::create(
                        TransporterInterface::POST,
                        sprintf('%s/%s', $threadsUserId, self::CREATE_MEDIA_CONTAINER_URI),
                        $data
                    )
                )
            );
    }

    public function publishMediaContainer(string $threadsUserId, array $data): MediaContainer
    {
        return
            MediaContainer::fromResponse(
                $this->transporter->request(
                    Payload::create(
                        TransporterInterface::POST,
                        sprintf('%s/%s', $threadsUserId, self::PUBLISH_MEDIA_CONTAINER_URI),
                        $data
                    )
                )
            );
    }
}
