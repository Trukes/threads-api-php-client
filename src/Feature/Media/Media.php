<?php

namespace Trukes\ThreadsApiPhpClient\Feature\Media;

use Trukes\ThreadsApiPhpClient\DTO\Payload;
use Trukes\ThreadsApiPhpClient\Feature\Media\DTO\RelyManagementCollection;
use Trukes\ThreadsApiPhpClient\Feature\Media\DTO\Item;
use Trukes\ThreadsApiPhpClient\TransporterInterface;
use Trukes\ThreadsApiPhpClient\TransporterTrait;
use Exception;

final class Media implements MediaInterface
{
    use TransporterTrait;

    private const LIST_ALL_URI = 'threads';
    private const SINGLE_URI = '';

    /**
     * @throws Exception
     */
    public function singleThreadsMedia(string $threadsUserId, array $fields, array $queryParams): Item
    {
        return Item::fromResponse(
            $this->transporter->request(
                Payload::create(
                    TransporterInterface::GET,
                    sprintf('%s', $threadsUserId),
                    [
                        ...$queryParams,
                        'fields' => implode(',', $fields)
                    ]
                )
            )
        );
    }

    /**
     * @throws Exception
     */
    public function listAllUsersThreads(string $threadsUserId, array $fields, array $queryParams): RelyManagementCollection
    {
        return RelyManagementCollection::fromResponse(
            $this->transporter->request(
                Payload::create(
                    TransporterInterface::GET,
                    sprintf('%s/%s', $threadsUserId, self::LIST_ALL_URI),
                    [
                        ...$queryParams,
                        'fields' => implode(',', $fields)
                    ]
                )
            )
        );
    }
}