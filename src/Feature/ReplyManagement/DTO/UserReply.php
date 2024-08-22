<?php
declare(strict_types=1);

namespace Trukes\ThreadsApiPhpClient\Feature\ReplyManagement\DTO;

use Trukes\ThreadsApiPhpClient\Service\Collection\ItemInterface;
use DateTime;

final class UserReply implements ItemInterface
{
    private function __construct(
        public readonly ?string   $id,
        public readonly ?string   $text,
        public readonly ?string   $username,
        public readonly ?string   $permalink,
        public readonly ?DateTime $timestamp,
        public readonly ?string   $media_product_type,
        public readonly ?string   $media_type,
        public readonly ?string   $media_url,
        public readonly ?string   $shortcode,
        public readonly ?string   $thumbnail_url,
        public readonly ?string   $children,
        public readonly ?bool     $is_quote_post,
        public readonly ?bool     $has_replies,
        public readonly RootPost  $root_post,
        public readonly ReplyTo   $replied_to,
        public readonly ?bool     $is_reply,
        public readonly ?bool     $is_reply_owned_by_me,
        public readonly ?string   $reply_audience,
    )
    {
    }

    public static function fromArray(array $item): self
    {
        return new self(
            $item['id'] ?? null,
            $item['text'] ?? null,
            $item['username'] ?? null,
            $item['permalink'] ?? null,
            array_key_exists('timestamp', $item) ? new DateTime($item['timestamp']) : null,
            $item['media_product_type'] ?? null,
            $item['media_type'] ?? null,
            $item['media_url'] ?? null,
            $item['shortcode'] ?? null,
            $item['thumbnail_url'] ?? null,
            $item['children'] ?? null,
            $item['is_quote_post'] ?? null,
            $item['has_replies'] ?? null,
            RootPost::fromArray($item['root_post'] ?? []),
            ReplyTo::fromArray($item['replied_to'] ?? []),
            $item['is_reply'] ?? null,
            $item['is_reply_owned_by_me'] ?? null,
            $item['reply_audience'] ?? null,
        );
    }
}