<?php
declare(strict_types=1);

namespace Trukes\ThreadsApiPhpClient\Reference\Container\Publish;

use Trukes\ThreadsApiPhpClient\DTO\Payload;
use Trukes\ThreadsApiPhpClient\DTO\Response;
use Trukes\ThreadsApiPhpClient\Reference\Container\Publish\Exception\PublishException;
use Trukes\ThreadsApiPhpClient\Reference\Container\Publish\Factory\Create;
use Trukes\ThreadsApiPhpClient\Reference\Container\Publish\Factory\Status;
use Trukes\ThreadsApiPhpClient\TransporterInterface;
use Trukes\ThreadsApiPhpClient\TransporterTrait;
use Trukes\ThreadsApiPhpClient\Reference\Container\Publish\Factory\Publish as PublishFactory;

final class Publish implements PublishInterface
{
    use TransporterTrait;

    /**
     * @throws PublishException
     */
    public function create(
        string  $threads_user_id,
        string  $media_type,
        ?string $text = null,
        ?string $image_url = null,
        ?string $video_url = null,
        ?bool   $is_carousel_item = null,
        ?array  $children = null,
        ?string $reply_to_id = null,
        ?string $reply_control = null,
        ?array  $allowlisted_country_codes = null,
        ?string $all_text = null,
    ): Response
    {
        return $this->transporter->request(
            Payload::create(
                method: TransporterInterface::POST,
                uri: sprintf('%s/threads', $threads_user_id),
                bodyForm: Create::create()
                    ->withMediaType($media_type)
                    ->withText($text)
                    ->withImageUrl($image_url)
                    ->withVideoUrl($video_url)
                    ->withIsCarouselItem($is_carousel_item)
                    ->withChildren($children)
                    ->withReplyToId($reply_to_id)
                    ->withReplyControl($reply_control)
                    ->withAllowlistedCountryCodes($allowlisted_country_codes)
                    ->withAllText($all_text)
                    ->toArray()
            )
                ->withAccessTokenOnQueryParams(false)
                ->withAccessTokenOnBodyForm(true)
        );
    }

    public function publish(string $threads_user_id, string $creation_id): Response
    {
        return $this->transporter->request(
            Payload::create(
                method: TransporterInterface::POST,
                uri: sprintf('%s/threads', $threads_user_id),
                bodyForm: PublishFactory::create()
                    ->withCreationId($creation_id)
                    ->toArray()
            )
                ->withAccessTokenOnQueryParams(false)
                ->withAccessTokenOnBodyForm(true)
        );
    }

    public function status(string $threads_container_id, ?string $fields): Response
    {
        return $this->transporter->request(
            Payload::create(
                method: TransporterInterface::GET,
                uri: sprintf('%s', $threads_container_id),
                queryParameters: Status::create()
                    ->withFields($fields)
                    ->toArray()
            )
        );
    }
}