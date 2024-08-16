<?php

namespace Trukes\ThreadsApiPhpClient;

use Trukes\ThreadsApiPhpClient\Feature\Posts\Posts;
use Trukes\ThreadsApiPhpClient\Feature\Posts\PostsInterface;

final class Client implements ClientInterface
{
    public function __construct(private readonly TransporterInterface $transporter)
    {
    }

    public function posts(): PostsInterface
    {
        return new Posts($this->transporter);
    }
}