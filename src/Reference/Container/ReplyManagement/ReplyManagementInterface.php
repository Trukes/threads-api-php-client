<?php
declare(strict_types=1);

namespace Trukes\ThreadsApiPhpClient\Reference\Container\ReplyManagement;

use Trukes\ThreadsApiPhpClient\DTO\Response;

interface ReplyManagementInterface
{
    // GET /{threads-media-id}/replies
    public function replies(string $threads_media_id, ?string $fields = null, ?bool $reverse = null, ?string $before = null, ?string $after = null): Response;
    // GET /{threads-media-id}/conversation
    public function conversation(string $threads_media_id, ?string $fields = null, ?bool $reverse = null, ?string $before = null, ?string $after = null): Response;

    // POST /{threads-reply-id}/manage_reply
    public function manageReply(string $threads_reply_id, ?bool $hide = null): Response;
}