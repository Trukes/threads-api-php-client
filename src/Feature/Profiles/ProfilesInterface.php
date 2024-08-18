<?php

namespace Trukes\ThreadsApiPhpClient\Feature\Profiles;

use Trukes\ThreadsApiPhpClient\Feature\Profiles\DTO\Profile;

interface ProfilesInterface
{
    public function getProfileInformation(string $threadsUserId, array $fields, array $queryParameters): Profile;
}