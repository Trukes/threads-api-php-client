<?php
declare(strict_types=1);

namespace Trukes\ThreadsApiPhpClient\Reference\Container\Publish;

use Trukes\ThreadsApiPhpClient\DTO\Response;

interface PublishInterface
{
    // POST /{threads-user-id}/threads
    public function create(
        string $threads_user_id,
        string $media_type,
        ?string $text,
        ?string $image_url,
        ?string $video_url,
        ?bool $is_carousel_item,
        ?array $children,
        ?string $reply_to_id,
        ?string $reply_control,
        ?array $allowlisted_country_codes,
        ?string $all_text,
    ): Response;

    // POST /{threads-user-id}/threads_publish
    public function publish(string $threads_user_id, string $creation_id): Response;

    // GET /{threads-container-id}?fields=status
    public function status(string $threads_container_id, ?string $fields): Response;

}