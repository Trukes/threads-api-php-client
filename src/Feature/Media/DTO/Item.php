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
        public readonly ?string            $mediaUrl,
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
            $data['id'] ?? null,
            $data['media_url'] ?? null,
            $data['media_product_type']  ?? null,
            $data['media_type']  ?? null,
            $data['permalink']  ?? null,
            Owner::fromArray($data['owner'] ?? []),
            $data['username'] ?? null,
            $data['text'] ?? null,
            array_key_exists('timestamp', $data) ? new DateTime($data['timestamp']) : null,
            $data['shortcode'] ?? null,
            $data['is_quote_post'] ?? null
        );
    }
}