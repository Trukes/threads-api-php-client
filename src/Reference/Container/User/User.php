<?php
declare(strict_types=1);

namespace Trukes\ThreadsApiPhpClient\Reference\Container\User;

use Trukes\ThreadsApiPhpClient\Reference\Container\User\Factory\Profile;
use Trukes\ThreadsApiPhpClient\Reference\Container\User\Factory\PublishLimit;
use Trukes\ThreadsApiPhpClient\Reference\Container\User\Factory\Replies;
use Trukes\ThreadsApiPhpClient\Reference\Container\User\Factory\Threads;
use Trukes\ThreadsApiPhpClient\Transporter\TransporterInterface;
use Trukes\ThreadsApiPhpClient\Transporter\TransporterTrait;
use Trukes\ThreadsApiPhpClient\ValueObject\Payload;
use Trukes\ThreadsApiPhpClient\ValueObject\Response;

final class User implements UserInterface
{
    use TransporterTrait;

    public function threads(string $threadsUserId, ?string $fields, ?string $since, ?string $until, ?int $limit, ?string $before, ?string $after): Response
    {
        return $this->transporter->request(
            Payload::create(
                method: TransporterInterface::GET,
                uri: sprintf('%s/threads', $threadsUserId),
                queryParameters: Threads::create()
                    ->withFields($fields)
                    ->withSince($since)
                    ->withUntil($until)
                    ->withLimit($limit)
                    ->withBefore($before)
                    ->withAfter($after)
                    ->toArray()
            )
        );
    }

    public function publishLimit(string $threadsUserId, ?string $fields): Response
    {
        return $this->transporter->request(
            Payload::create(
                method: TransporterInterface::GET,
                uri: sprintf('%s/threads_publishing_limit', $threadsUserId),
                queryParameters: PublishLimit::create()
                    ->withFields($fields)
                    ->toArray()
            )
        );
    }

    public function profile(string $threadsUserId, ?string $fields): Response
    {
        return $this->transporter->request(
            Payload::create(
                method: TransporterInterface::GET,
                uri: sprintf('%s', $threadsUserId),
                queryParameters: Profile::create()
                    ->withFields($fields)
                    ->toArray()
            )
        );
    }

    public function replies(string $threadsUserId, ?string $fields, ?string $since, ?string $until, ?int $limit, ?string $before, ?string $after): Response
    {
        return $this->transporter->request(
            Payload::create(
                method: TransporterInterface::GET,
                uri: sprintf('%s/replies', $threadsUserId),
                queryParameters: Replies::create()
                    ->withFields($fields)
                    ->withSince($since)
                    ->withUntil($until)
                    ->withLimit($limit)
                    ->withBefore($before)
                    ->withAfter($after)
                    ->toArray()
            )
        );
    }
}