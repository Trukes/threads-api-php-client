<?php

namespace Trukes\ThreadsApiPhpClient\Feature\Media\DTO;

use DateTimeInterface;
use Trukes\ThreadsApiPhpClient\DTO\Response;
use DateTime;
use Trukes\ThreadsApiPhpClient\Service\FromResponseInterface;
use Exception;

final class Item implements FromResponseInterface
{
    public function __construct(
        public readonly ?int               $id,
        public readonly ?string            $mediaProductType,
        public readonly ?string            $mediaType,
        public readonly ?string            $permalink,
        public readonly ?Owner             $owner,
        public readonly ?string            $username,
        public readonly ?string            $text,
        public readonly ?DateTimeInterface $timestamp,
        public readonly ?string            $shortcode,
        public readonly ?bool              $isQuotePost
    )
    {
    }

    /**
     * @throws Exception
     */
    public static function fromResponse(Response $response): self
    {
        $data = $response->data();

        return self::fromArray($data);
    }

    /**
     * @throws Exception
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'],
            $data['media_product_type'],
            $data['media_type'],
            $data['permalink'],
            new Owner($data['owner']['id'] ?? null),
            $data['username'],
            $data['text'],
            new DateTime($data['timestamp']),
            $data['shortcode'],
            $data['is_quote_post']
        );
    }
}