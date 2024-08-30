<?php
declare(strict_types=1);

namespace Tests\Responses;

final class MediaResponse
{
    public const THREADS_MEDIA_FULL_RESPONSE = '{
  "id": "1234567",
  "media_product_type": "THREADS",
  "media_type": "TEXT_POST",
  "permalink": "https://www.threads.net/@threadsapitestuser/post/abcdefg",
  "owner": {
    "id": "1234567"
  },
  "username": "threadsapitestuser",
  "text": "Hello World",
  "timestamp": "2023-10-09T23:18:27+0000",
  "shortcode": "abcdefg",
  "is_quote_post": false
}';
}