<?php

namespace Trukes\ThreadsApiPhpClient;

use Trukes\ThreadsApiPhpClient\Transporter\TransporterInterface;

trait TransporterTrait
{
    public function __construct(private readonly TransporterInterface $transporter)
    {
    }
}