<?php

namespace Trukes\ThreadsApiPhpClient;

use Psr\Http\Message\ResponseInterface;

interface TransporterInterface
{
    public const POST = 'POST';
    public const GET = 'GET';
    public const PUT = 'PUT';
    public const DELETE = 'DELETE';

    public function request(string $method, $uri, array $options = []): ResponseInterface;
}
