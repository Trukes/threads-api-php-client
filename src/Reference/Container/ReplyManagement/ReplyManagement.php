<?php
declare(strict_types=1);

namespace Trukes\ThreadsApiPhpClient\Reference\Container\ReplyManagement;

use Trukes\ThreadsApiPhpClient\Reference\Container\ReplyManagement\Factory\Conversation;
use Trukes\ThreadsApiPhpClient\Reference\Container\ReplyManagement\Factory\ManageReply;
use Trukes\ThreadsApiPhpClient\Reference\Container\ReplyManagement\Factory\Replies;
use Trukes\ThreadsApiPhpClient\Transporter\TransporterInterface;
use Trukes\ThreadsApiPhpClient\TransporterTrait;
use Trukes\ThreadsApiPhpClient\ValueObject\Payload;
use Trukes\ThreadsApiPhpClient\ValueObject\Response;

final class ReplyManagement implements ReplyManagementInterface
{
    use TransporterTrait;

    public function replies(string $threads_media_id, ?string $fields = null, ?bool $reverse = null, ?string $before = null, ?string $after = null): Response
    {
        return $this->transporter->request(
            Payload::create(
                method: TransporterInterface::GET,
                uri: sprintf('%s/replies', $threads_media_id),
                queryParameters: Replies::create()
                    ->withFields($fields)
                    ->withReverse($reverse)
                    ->withBefore($before)
                    ->withAfter($after)
                    ->toArray()
            )
        );
    }

    public function conversation(string $threads_media_id, ?string $fields = null, ?bool $reverse = null, ?string $before = null, ?string $after = null): Response
    {
        return $this->transporter->request(
            Payload::create(
                method: TransporterInterface::GET,
                uri: sprintf('%s/conversation', $threads_media_id),
                queryParameters: Conversation::create()
                    ->withFields($fields)
                    ->withReverse($reverse)
                    ->withBefore($before)
                    ->withAfter($after)
                    ->toArray()
            )
        );
    }

    public function manageReply(string $threads_reply_id, ?bool $hide = null): Response
    {
        return $this->transporter->request(
            Payload::create(
                method: TransporterInterface::POST,
                uri: sprintf('%s/manage_reply', $threads_reply_id),
                bodyForm: ManageReply::create()
                    ->withHide($hide)
                    ->toArray()
            )
                ->withAccessTokenOnQueryParams(false)
                ->withAccessTokenOnBodyForm(true)
        );
    }
}