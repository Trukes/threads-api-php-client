<?php
declare(strict_types=1);

namespace Trukes\ThreadsApiPhpClient;

use Trukes\ThreadsApiPhpClient\Reference\Container\Insights\Insights;
use Trukes\ThreadsApiPhpClient\Reference\Container\Media\Media;
use Trukes\ThreadsApiPhpClient\Reference\Container\Publish\Publish;
use Trukes\ThreadsApiPhpClient\Reference\Container\ReplyManagement\ReplyManagement;
use Trukes\ThreadsApiPhpClient\Reference\Container\User\User;

final class Client implements ClientInterface
{
    public function __construct(
        private readonly Publish         $publish,
        private readonly Media           $media,
        private readonly ReplyManagement $replyManagement,
        private readonly User            $user,
        private readonly Insights        $insights,
    )
    {
    }

    public function publish(): Publish
    {
        return $this->publish;
    }

    public function media(): Media
    {
        return $this->media;
    }

    public function replyManagement(): ReplyManagement
    {
        return $this->replyManagement;
    }

    public function user(): User
    {
        return $this->user;
    }

    public function insights(): Insights
    {
        return $this->insights;
    }
}
