<?php
declare(strict_types=1);

namespace Trukes\ThreadsApiPhpClient\Reference\Container\Media;

use Trukes\ThreadsApiPhpClient\ValueObject\Response;

interface MediaInterface
{
    public function mediaObject(string $threads_media_id, string $fields): Response;
}