<?php
declare(strict_types=1);

namespace Trukes\ThreadsApiPhpClient\Feature\Media\DTO;

use DateTimeInterface;
use Trukes\ThreadsApiPhpClient\DTO\Response;
use DateTime;
use Trukes\ThreadsApiPhpClient\Service\Collection\ItemInterface;
use Trukes\ThreadsApiPhpClient\Service\FromResponseInterface;
use Exception;

final class Item implements FromResponseInterface, ItemInterface
{
    private function __construct(
        public readonly ?string            $id,
        public readonly ?string            $mediaUrl,
        public readonly ?string            $mediaProductType,
        public readonly ?string            $mediaType,
        public readonly ?string            $permalink,
        public readonly Owner             $owner,
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
    public static function fromArray(array $item): self
    {
        return new self(
            $item['id'] ?? null,
            $item['media_url'] ?? null,
            $item['media_product_type'] ?? null,
            $item['media_type'] ?? null,
            $item['permalink'] ?? null,
            Owner::fromArray($item['owner'] ?? []),
            $item['username'] ?? null,
            $item['text'] ?? null,
            array_key_exists('timestamp', $item) ? new DateTime($item['timestamp']) : null,
            $item['shortcode'] ?? null,
            $item['is_quote_post'] ?? null
        );
    }
}