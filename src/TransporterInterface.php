<?php

namespace Trukes\ThreadsApiPhpClient;

use Trukes\ThreadsApiPhpClient\DTO\Payload;
use Trukes\ThreadsApiPhpClient\DTO\Response;

interface TransporterInterface
{
    public const POST = 'POST';
    public const GET = 'GET';

    public function request(Payload $payload): Response;
}
