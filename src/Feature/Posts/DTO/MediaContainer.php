<?php

namespace Trukes\ThreadsApiPhpClient\Feature\Posts\DTO;

use Trukes\ThreadsApiPhpClient\DTO\Response;
use Trukes\ThreadsApiPhpClient\Feature\Posts\Exception\PostsFeatureException;

final class MediaContainer
{
    public function __construct(public readonly string $id)
    {
    }

    /**
     * @throws PostsFeatureException
     */
    public static function fromResponse(Response $response): self
    {
        if(!array_key_exists('id', $response->data())){
            throw PostsFeatureException::mediaContainerNoIdFound();
        }

        return new self($response->data()['id']);
    }
}