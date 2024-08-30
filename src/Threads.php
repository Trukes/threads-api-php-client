<?php
declare(strict_types=1);

namespace Trukes\ThreadsApiPhpClient;

final class Threads
{
    public static function client(?string $accessToken): Client
    {
        return self::factory()
            ->withConfig()
            ->withAccessToken($accessToken)
            ->make();
    }

    public static function factory(): Factory
    {
        return new Factory();
    }
}