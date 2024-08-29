<?php
declare(strict_types=1);

namespace Trukes\ThreadsApiPhpClient\Reference\Container\ReplyManagement\Factory;

use Trukes\ThreadsApiPhpClient\Reference\Shared\AbstractItemFactory;

final class ManageReply extends AbstractItemFactory
{
    private ?bool $hide = null;

    public function withHide(bool $hide): self
    {
        $this->hide = $hide;

        return $this;
    }

    public function toParams(): array
    {
        return [
            'hide' => $this->hide,
        ];
    }
}