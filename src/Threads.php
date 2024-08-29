<?php

namespace Trukes\ThreadsApiPhpClient;

use Trukes\ThreadsApiPhpClient\Reference\Reference;

final class Threads
{
    public static function client(?string $accessToken): Reference
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