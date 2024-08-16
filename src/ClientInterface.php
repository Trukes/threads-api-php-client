<?php

namespace Trukes\ThreadsApiPhpClient;

use Trukes\ThreadsApiPhpClient\Feature\Posts\PostsInterface;

interface ClientInterface
{
    public function posts(): PostsInterface;
}