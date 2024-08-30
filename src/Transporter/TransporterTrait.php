<?php
declare(strict_types=1);

namespace Trukes\ThreadsApiPhpClient\Transporter;

trait TransporterTrait
{
    public function __construct(private readonly TransporterInterface $transporter)
    {
    }
}