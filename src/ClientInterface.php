<?php

namespace Trukes\ThreadsApiPhpClient;

use Trukes\ThreadsApiPhpClient\Feature\PostsInterface;

interface ClientInterface
{
    public function posts(): PostsInterface;
}