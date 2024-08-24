<?php
declare(strict_types=1);

namespace Trukes\ThreadsApiPhpClient;

use Trukes\ThreadsApiPhpClient\Feature\Insights\InsightsInterface;
use Trukes\ThreadsApiPhpClient\Feature\Media\MediaInterface;
use Trukes\ThreadsApiPhpClient\Feature\Posts\PostsInterface;
use Trukes\ThreadsApiPhpClient\Feature\Profiles\ProfilesInterface;
use Trukes\ThreadsApiPhpClient\Feature\ReplyManagement\ReplyManagementInterface;

interface ClientInterface
{
    public function posts(): PostsInterface;
    public function media(): MediaInterface;
    public function profiles(): ProfilesInterface;
    public function replyManagement(): ReplyManagementInterface;
    public function insights(): InsightsInterface;
}
