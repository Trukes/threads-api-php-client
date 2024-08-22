<?php
declare(strict_types=1);

namespace Trukes\ThreadsApiPhpClient\Feature\Insights\DTO;

use Trukes\ThreadsApiPhpClient\DTO\Response;
use Trukes\ThreadsApiPhpClient\Service\FromResponseInterface;

final class MediaInsights implements FromResponseInterface
{
    public static function fromResponse(Response $response): FromResponseInterface
    {
        // TODO: Implement fromResponse() method.
    }
}