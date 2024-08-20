<?php
declare(strict_types=1);

namespace Trukes\ThreadsApiPhpClient\Feature\ReplyManagement\DTO;

use Trukes\ThreadsApiPhpClient\Service\Collection\ItemInterface;

final class Thread implements ItemInterface
{
    public function __construct(
        public readonly ?string  $id,
        public readonly ?string  $text,
        public readonly ?string  $username,
        public readonly ?string  $permalink,
        public readonly ?string  $timestamp,
        public readonly ?string  $mediaProductType,
        public readonly ?string  $mediaType,
        public readonly ?string  $mediaUrl,
        public readonly ?string  $shortcode,
        public readonly ?string  $thumbnailUrl,
        public readonly ?string  $children,
        public readonly ?bool    $isQuotePost,
        public readonly ?bool    $hasReplies,
        public readonly RootPost $rootPost,
        public readonly ReplyTo  $repliedTo,
        public readonly ?bool    $isReply,
        public readonly ?bool    $isReplyOwnedByMe,
        public readonly ?string  $hideStatus,
        public readonly ?string  $replyAudience,
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
            $item['timestamp'] ?? null,
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
            $item['hide_status'] ?? null,
            $item['reply_audience'] ?? null,
        );
    }
}
