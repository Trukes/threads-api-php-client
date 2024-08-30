<?php

namespace Trukes\ThreadsApiPhpClient\Service;

use Trukes\ThreadsApiPhpClient\ValueObject\Response;

interface FromResponseInterface
{
    public static function fromResponse(Response $response): self;
}