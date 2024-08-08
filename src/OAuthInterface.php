<?php

namespace Trukes\ThreadsApiPhpClient;

interface OAuthInterface
{
    public function getAuthorizationUrl(array $options = []): string;
}