<?php

namespace Trukes\ThreadsApiPhpClient\Transporter;

use Trukes\ThreadsApiPhpClient\ValueObject\Payload;
use Trukes\ThreadsApiPhpClient\ValueObject\Response;

interface TransporterInterface
{
    public const POST = 'POST';
    public const GET = 'GET';

    public function request(Payload $payload): Response;
}
