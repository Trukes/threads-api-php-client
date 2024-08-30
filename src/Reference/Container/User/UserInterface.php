<?php
declare(strict_types=1);

namespace Trukes\ThreadsApiPhpClient\Reference\Container\User;

use Trukes\ThreadsApiPhpClient\ValueObject\Response;

interface UserInterface
{
    // GET /{threads-user-id}/threads
    public function threads(string $threadsUserId, ?string $fields, ?string $since, ?string $until, ?int $limit, ?string $before, ?string $after): Response;
    // GET /{threads-user-id}/threads_publishing_limit
    public function publishLimit(string $threadsUserId, ?string $fields): Response;
    // GET /{threads-user-id}?fields=id,username,...
    public function profile(string $threadsUserId, ?string $fields): Response;
    // GET /{threads-user-id}/replies
    public function replies(string $threadsUserId, ?string $fields, ?string $since, ?string $until, ?int $limit, ?string $before, ?string $after): Response;
}