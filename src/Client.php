<?php
declare(strict_types=1);

namespace Trukes\ThreadsApiPhpClient;

use Trukes\ThreadsApiPhpClient\Feature\Insights\Insights;
use Trukes\ThreadsApiPhpClient\Feature\Insights\InsightsInterface;
use Trukes\ThreadsApiPhpClient\Feature\Media\Media;
use Trukes\ThreadsApiPhpClient\Feature\Media\MediaInterface;
use Trukes\ThreadsApiPhpClient\Feature\Posts\Posts;
use Trukes\ThreadsApiPhpClient\Feature\Posts\PostsInterface;
use Trukes\ThreadsApiPhpClient\Feature\Profiles\Profiles;
use Trukes\ThreadsApiPhpClient\Feature\Profiles\ProfilesInterface;
use Trukes\ThreadsApiPhpClient\Feature\ReplyManagement\ReplyManagement;
use Trukes\ThreadsApiPhpClient\Feature\ReplyManagement\ReplyManagementInterface;

final class Client implements ClientInterface
{
    public function __construct(private readonly TransporterInterface $transporter)
    {
    }

    public function posts(): PostsInterface
    {
        return new Posts($this->transporter);
    }

    public function media(): MediaInterface
    {
        return new Media($this->transporter);
    }

    public function profiles(): ProfilesInterface
    {
        return new Profiles($this->transporter);
    }

    public function replyManagement(): ReplyManagementInterface
    {
        return new ReplyManagement($this->transporter);
    }

    public function insights(): InsightsInterface
    {
        return new Insights($this->transporter);
    }
}
