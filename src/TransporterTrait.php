<?php

namespace Trukes\ThreadsApiPhpClient;

trait TransporterTrait
{
    public function __construct(private readonly TransporterInterface $transporter)
    {
    }
}