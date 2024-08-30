<?php
declare(strict_types=1);

namespace Trukes\ThreadsApiPhpClient;

use Trukes\ThreadsApiPhpClient\Reference\Container\Insights\Insights;
use Trukes\ThreadsApiPhpClient\Reference\Container\Media\Media;
use Trukes\ThreadsApiPhpClient\Reference\Container\Publish\Publish;
use Trukes\ThreadsApiPhpClient\Reference\Container\ReplyManagement\ReplyManagement;
use Trukes\ThreadsApiPhpClient\Reference\Container\User\User;

interface ClientInterface
{
    public function publish(): Publish;
    public function media(): Media;
    public function replyManagement(): ReplyManagement;
    public function user(): User;
    public function insights(): Insights;
}