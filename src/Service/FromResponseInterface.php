<?php

namespace Trukes\ThreadsApiPhpClient\Service;

use Trukes\ThreadsApiPhpClient\DTO\Response;

interface FromResponseInterface
{
    public static function fromResponse(Response $response): self;
}