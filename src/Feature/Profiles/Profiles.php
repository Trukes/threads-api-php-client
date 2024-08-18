<?php

namespace Trukes\ThreadsApiPhpClient\Feature\Profiles;

use Trukes\ThreadsApiPhpClient\DTO\Payload;
use Trukes\ThreadsApiPhpClient\Feature\Profiles\DTO\Profile;
use Trukes\ThreadsApiPhpClient\TransporterInterface;
use Trukes\ThreadsApiPhpClient\TransporterTrait;

final class Profiles implements ProfilesInterface
{
    use TransporterTrait;

    public function getProfileInformation(string $threadsUserId, array $fields, array $queryParameters): Profile
    {
        return Profile::fromResponse(
            $this->transporter->request(
                Payload::create(
                    TransporterInterface::GET,
                    sprintf('%s', $threadsUserId),
                    [
                        ...$queryParameters,
                        'fields' => implode(',', $fields)
                    ]
                )
            )
        );
    }
}