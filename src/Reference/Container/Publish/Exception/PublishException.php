<?php
declare(strict_types=1);

namespace Trukes\ThreadsApiPhpClient\Reference\Container\Publish\Exception;

use Exception;

final class PublishException extends Exception
{
    public static function invalidArgument(string $message): self
    {
        return new self($message);
    }
}