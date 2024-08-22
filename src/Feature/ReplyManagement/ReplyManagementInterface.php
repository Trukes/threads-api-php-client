<?php
declare(strict_types=1);

namespace Trukes\ThreadsApiPhpClient\Feature\ReplyManagement;

use Trukes\ThreadsApiPhpClient\Feature\ReplyManagement\DTO\HideReplies;
use Trukes\ThreadsApiPhpClient\Feature\ReplyManagement\DTO\MediaContainer;
use Trukes\ThreadsApiPhpClient\Feature\ReplyManagement\DTO\ThreadsCollectionConversation;
use Trukes\ThreadsApiPhpClient\Feature\ReplyManagement\DTO\ThreadsCollectionReplies;
use Trukes\ThreadsApiPhpClient\Feature\ReplyManagement\DTO\UserReplies;

interface ReplyManagementInterface
{
    public function threadReplies(string $mediaId, array $fields, array $queryParameters): ThreadsCollectionReplies;
    public function threadConversation(string $mediaId, array $fields, array $queryParameters): ThreadsCollectionConversation;
    public function userReplies(string $threadsUserId, array $fields, array $queryParameters): UserReplies;
    public function hideReplies(string $threadsReplyId, array $formFields): HideReplies;
    public function createRespondReplies(array $formFields, string $threadsUserId = 'me'): MediaContainer;
    public function publishRespondReplies(string $threadsUserId, array $queryParameters): MediaContainer;
    public function controlWhoCanReply(array $formFields, string $threadsUserId = 'me'): MediaContainer;
    public function publishWhoCanReply(array $queryParameters, string $threadsUserId = 'me'): MediaContainer;
}