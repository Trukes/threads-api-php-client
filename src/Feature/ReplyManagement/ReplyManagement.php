<?php
declare(strict_types=1);

namespace Trukes\ThreadsApiPhpClient\Feature\ReplyManagement;

use Trukes\ThreadsApiPhpClient\DTO\Payload;
use Trukes\ThreadsApiPhpClient\Feature\ReplyManagement\DTO\HideReplies;
use Trukes\ThreadsApiPhpClient\Feature\ReplyManagement\DTO\MediaContainer;
use Trukes\ThreadsApiPhpClient\Feature\ReplyManagement\DTO\ThreadsCollectionConversation;
use Trukes\ThreadsApiPhpClient\Feature\ReplyManagement\DTO\ThreadsCollectionReplies;
use Trukes\ThreadsApiPhpClient\Feature\ReplyManagement\DTO\UserReplies;
use Trukes\ThreadsApiPhpClient\TransporterInterface;
use Trukes\ThreadsApiPhpClient\TransporterTrait;

final class ReplyManagement implements ReplyManagementInterface
{
    use TransporterTrait;

    public function threadReplies(string $mediaId, array $fields, array $queryParameters): ThreadsCollectionReplies
    {
        $response = ThreadsCollectionReplies::fromResponse(
            $this->transporter->request(
                Payload::create(
                    TransporterInterface::GET,
                    sprintf('%s/replies', $mediaId),
                    [
                        ...$queryParameters,
                        'fields' => implode(',', $fields)
                    ]
                )
            )
        );

        assert($response instanceof ThreadsCollectionReplies);

        return $response;
    }

    public function threadConversation(string $mediaId, array $fields, array $queryParameters): ThreadsCollectionConversation
    {
        $response = ThreadsCollectionConversation::fromResponse(
            $this->transporter->request(
                Payload::create(
                    TransporterInterface::GET,
                    sprintf('%s/conversation', $mediaId),
                    [
                        ...$queryParameters,
                        'fields' => implode(',', $fields)
                    ]
                )
            )
        );

        assert($response instanceof ThreadsCollectionConversation);

        return $response;
    }

    public function userReplies(string $threadsUserId, array $fields, array $queryParameters): UserReplies
    {
        return new UserReplies();
    }

    public function hideReplies(string $threadsReplyId, array $fields, array $queryParameters): HideReplies
    {
        return new HideReplies();
    }

    public function createRespondReplies(string $threadsReplyId, array $fields, array $queryParameters): MediaContainer
    {
        return new MediaContainer();
    }

    public function publishRespondReplies(string $threadsUserId, array $fields, array $queryParameters): MediaContainer
    {
        return new MediaContainer();
    }

    public function controlWhoCanReply(string $threadsUserId, array $fields, array $queryParameters): MediaContainer
    {
        return new MediaContainer();
    }

    public function publishWhoCanReply(string $threadsUserId, array $fields, array $queryParameters): MediaContainer
    {
        return new MediaContainer();
    }
}