<?php
declare(strict_types=1);

namespace Trukes\ThreadsApiPhpClient\Reference\Container\Publish\Factory;

use Trukes\ThreadsApiPhpClient\Reference\Container\Publish\Exception\PublishException;
use Trukes\ThreadsApiPhpClient\Reference\Shared\AbstractItemFactory;

final class Create extends AbstractItemFactory
{
    public const MEDIA_TYPE = [
        'TEXT',
        'IMAGE',
        'VIDEO',
        'CAROUSEL'
    ];

    public const REPLY_CONTROL = [
        'everyone',
        'accounts_you_follow',
        'mentioned_only'
    ];

    // Values: TEXT, IMAGE, VIDEO, CAROUSEL
    private string $mediaType;
    private ?string $text;

    // Required if media_type=IMAGE.
    private ?string $imageUrl;

    // Required if media_type=VIDEO.
    private ?string $videoUrl;
    private ?bool $isCarouselItem;

    // Required if media_type=CAROUSEL.
    private ?array $children;

    // Required if replying to a specific reply under the root post. The caller should be the owner of the root post.
    private ?string $replyToId;

    // Values: everyone, accounts_you_follow, mentioned_only
    private ?string $replyControl;

    // A string list of valid ISO 3166-1 alpha-2 country codes that represents the countries where this media should be shown. If this parameter is passed in, the media will not be shown to Threads profiles in countries outside of this list.
    private ?array $allowlistedCountryCodes;

    // The accessibility text label or description for an image or video in a Threads post.
    // Note: The maximum length of alt_text is 1,000 characters.
    private ?string $allText;


    /**
     * @throws PublishException
     */
    public function withMediaType(string $mediaType): self
    {
        if (!in_array($mediaType, self::MEDIA_TYPE)) {
            throw PublishException::invalidArgument(sprintf('Invalid argument for %s. %s given', 'media_type', $mediaType));
        }

        $this->mediaType = $mediaType;

        return $this;
    }

    public function withText(?string $text): self
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @throws PublishException
     */
    public function withImageUrl(?string $imageUrl): self
    {
        if ($this->mediaType === 'IMAGE'
            && null === $imageUrl) {
            throw PublishException::invalidArgument('Image URL is needed for the IMAGE media type.');
        }

        $this->imageUrl = $imageUrl;

        return $this;
    }

    public function withVideoUrl(?string $videoUrl): self
    {
        if ($this->mediaType === 'VIDEO'
            && null === $videoUrl) {
            throw PublishException::invalidArgument('Video URL is needed for the VIDEO media type.');
        }

        $this->videoUrl = $videoUrl;

        return $this;
    }

    public function withIsCarouselItem(?bool $isCarouselItem): self
    {
        $this->isCarouselItem = $isCarouselItem;

        return $this;
    }

    public function withChildren(?array $children): self
    {
        $this->children = $children;

        return $this;
    }

    public function withReplyToId(?string $replyToId): self
    {
        $this->replyToId = $replyToId;

        return $this;
    }

    /**
     * @throws PublishException
     */
    public function withReplyControl(?string $replyControl): self
    {
        if (null !== $replyControl
            && !in_array($replyControl, self::REPLY_CONTROL)) {
            throw PublishException::invalidArgument(sprintf('Invalid argument for %s. %s given', 'reply_control', $replyControl));
        }

        $this->replyControl = $replyControl;

        return $this;
    }

    public function withAllowlistedCountryCodes(?array $allowlistedCountryCodes): self
    {
        $this->allowlistedCountryCodes = $allowlistedCountryCodes;

        return $this;
    }

    /**
     * @throws PublishException
     */
    public function withAllText(?string $allText): self
    {
        if (null !== $allText
            && strlen($allText) > 1000
        ) {
            throw PublishException::invalidArgument('The maximum length of alt_text is 1,000 characters.');
        }

        $this->allText = $allText;

        return $this;
    }

    public function toParams(): array
    {
        return [
            'media_type' => $this->mediaType,
            'text' => $this->text,
            'image_url' => $this->imageUrl,
            'video_url' => $this->videoUrl,
            'is_carousel_item' => $this->isCarouselItem,
            'children' => $this->children,
            'reply_to_id' => $this->replyToId,
            'reply_control' => $this->replyControl,
            'allowlisted_country_codes' => $this->allowlistedCountryCodes,
            'all_text' => $this->allText,
        ];
    }
}