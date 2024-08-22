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
        $response = UserReplies::fromResponse(
            $this->transporter->request(
                Payload::create(
                    TransporterInterface::GET,
                    sprintf('%s/replies', $threadsUserId),
                    [
                        ...$queryParameters,
                        'fields' => implode(',', $fields)
                    ]
                )
            )
        );

        assert($response instanceof UserReplies);

        return $response;
    }

    public function hideReplies(string $threadsReplyId, array $formFields): HideReplies
    {
        $response = HideReplies::fromResponse(
            $this->transporter->request(
                Payload::create(
                    method: TransporterInterface::POST,
                    uri: sprintf('%s/manage_reply', $threadsReplyId),
                    bodyForm: $formFields
                )
                    ->withAccessTokenOnQueryParams(false)
                    ->withAccessTokenOnBodyForm(true)
            )
        );

        assert($response instanceof HideReplies);

        return $response;
    }

    public function createRespondReplies(array $formFields, string $threadsUserId = 'me'): MediaContainer
    {
        $response = MediaContainer::fromResponse(
            $this->transporter->request(
                Payload::create(
                    method: TransporterInterface::POST,
                    uri: sprintf('%s/threads', $threadsUserId),
                    bodyForm: $formFields
                )
                    ->withAccessTokenOnQueryParams(false)
                    ->withAccessTokenOnBodyForm(true)
            )
        );

        assert($response instanceof MediaContainer);

        return $response;
    }

    public function publishRespondReplies(string $threadsUserId, array $queryParameters): MediaContainer
    {
        $response = MediaContainer::fromResponse(
            $this->transporter->request(
                Payload::create(
                    TransporterInterface::POST,
                    sprintf('%s/threads_publish', $threadsUserId),
                    $queryParameters
                )
            )
        );

        assert($response instanceof MediaContainer);

        return $response;
    }

    public function controlWhoCanReply(array $formFields, string $threadsUserId = 'me'): MediaContainer
    {
        $response = MediaContainer::fromResponse(
            $this->transporter->request(
                Payload::create(
                    method: TransporterInterface::POST,
                    uri: sprintf('%s/threads', $threadsUserId),
                    bodyForm: $formFields
                )
                    ->withAccessTokenOnQueryParams(false)
                    ->withAccessTokenOnBodyForm(true)
            )
        );

        assert($response instanceof MediaContainer);

        return $response;
    }

    public function publishWhoCanReply(array $queryParameters, string $threadsUserId = 'me'): MediaContainer
    {
        $response = MediaContainer::fromResponse(
            $this->transporter->request(
                Payload::create(
                    TransporterInterface::POST,
                    sprintf('%s/threads_publish', $threadsUserId),
                    $queryParameters
                )
            )
        );

        assert($response instanceof MediaContainer);

        return $response;
    }
}