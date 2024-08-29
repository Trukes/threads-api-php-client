<?php
declare(strict_types=1);

namespace Trukes\ThreadsApiPhpClient\Reference\Container\Media;

use Trukes\ThreadsApiPhpClient\DTO\Payload;
use Trukes\ThreadsApiPhpClient\DTO\Response;
use Trukes\ThreadsApiPhpClient\Reference\Container\Media\Factory\MediaObject;
use Trukes\ThreadsApiPhpClient\TransporterInterface;
use Trukes\ThreadsApiPhpClient\TransporterTrait;

final class Media implements MediaInterface
{
    use TransporterTrait;

    public function mediaObject(string $threads_media_id, string $fields): Response
    {
        return $this->transporter->request(
            Payload::create(
                method: TransporterInterface::GET,
                uri: sprintf('%s', $threads_media_id),
                queryParameters: MediaObject::create()
                    ->withFields($fields)
                    ->toArray()
            )
        );
    }
}