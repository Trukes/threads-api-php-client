<?php

namespace Trukes\ThreadsApiPhpClient\Exception;

use Exception;
use Throwable;

final class OAuthException extends Exception
{
    private string $error;
    private string $errorReason;
    private string $errorDescription;

    private function __construct(
        string $error,
        string $errorReason,
        string $errorDescription,
        $code = 0,
        Throwable $previous = null)
    {
        $this->error = $error;
        $this->errorReason = $errorReason;
        $this->errorDescription = $errorDescription;

        parent::__construct($errorDescription, $code, $previous);
    }

    public static function failed(
        string $error,
        string $errorReason,
        string $errorDescription,
        ?int $code = 0,
        ?Throwable $previous = null): self
    {
        return new self($error, $errorReason, $errorDescription, $code, $previous);
    }

    public function getError(): string
    {
        return $this->error;
    }
    public function getErrorReason(): string
    {
        return $this->errorReason;
    }
    public function getErrorDescription(): string
    {
        return $this->errorDescription;
    }
}