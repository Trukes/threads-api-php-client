<?php

namespace Trukes\ThreadsApiPhpClient\Feature\Posts\Exception;

use Exception;

final class PostsFeatureException extends \Exception
{
    public static function mediaContainerNoIdFound(): self
    {
        return new self('Response was invalid. No id found.');
    }
}