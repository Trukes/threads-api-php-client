<?php
declare(strict_types=1);

namespace Trukes\ThreadsApiPhpClient\Exception;

use Exception;

final class ErrorException extends Exception
{
    /**
     * Creates a new Exception instance.
     *
     * @param  array{message: string|array<int, string>, type: ?string, code: string|int|null}  $contents
     */
    public function __construct(private readonly array $contents)
    {
        $message = ($contents['message'] ?: (string) $this->contents['code']) ?: 'Unknown error';

        if (is_array($message)) {
            $message = implode(PHP_EOL, $message);
        }

        parent::__construct($message);
    }
}
