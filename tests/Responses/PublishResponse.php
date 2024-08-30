<?php
declare(strict_types=1);

namespace Tests\Responses;

final class PublishResponse
{
    public const THREADS_PUBLISH_CREATE_FULL_RESPONSE = '{
 "id": "1234567890"
}';

    public const THREADS_PUBLISH_FULL_RESPONSE = '{
 "id": "1234567890"
}';

    public const THREADS_PUBLISH_STATUS_FULL_RESPONSE = '{
   "id": "12312312312123",
   "status": "Published"
}';
}