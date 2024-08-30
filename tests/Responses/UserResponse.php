<?php
declare(strict_types=1);

namespace Tests\Responses;

final class UserResponse
{
    public const THREADS_USER_FULL_RESPONSE = '{
  "data": [
    {
      "id": "1234567",
      "media_product_type": "THREADS",
      "media_type": "TEXT_POST",
      "permalink": "https://www.threads.net/@threadsapitestuser/post/abcdefg",
      "owner": {
        "id": "1234567"
      },
      "username": "threadsapitestuser",
      "text": "Today Is Monday",
      "timestamp": "2023-10-17T05:42:03+0000",
      "shortcode": "abcdefg",
      "is_quote_post": false
    }
  ],
  "paging": {
    "cursors": {
      "before": "BEFORE_CURSOR",
      "after": "AFTER_CURSOR"
    }
  }
}';

    public const THREADS_USER_PUBLISH_LIMIT_RESPONSE = '{
  "data": [
    {
      "quota_usage": 4,
      "config": {
        "quota_total": 250,
        "quota_duration": 86400
      }
    }
  ]
}';

    public const THREADS_USER_PROFILE_RESPONSE = '{
  "id": "1234567",
  "username": "threadsapitestuser",
  "name": "Threads API Test User",
  "threads_profile_picture_url": "https://scontent-sjc3-1.cdninstagram.com/link/to/profile/picture/on/threads/",
  "threads_biography": "This is my Threads bio."
}';

    public const THREADS_USER_REPLIES_RESPONSE = '{
  "data": [
    {
      "id": "1234567",
      "media_product_type": "THREADS",
      "media_type": "TEXT_POST",
      "permalink": "https://www.threads.net/@threadsapitestuser/post/abcdefg",
      "username": "threadsapitestuser",
      "text": "Reply Text",
      "timestamp": "2023-10-17T05:42:03+0000",
      "shortcode": "abcdefg",
      "is_quote_post": false,
      "has_replies": false,
      "root_post": {
        "id": "1234567890"
      },
      "replied_to": {
        "id": "1234567890"
      },
      "is_reply": true,
      "is_reply_owned_by_me": true,
      "reply_audience": "EVERYONE"
    }
  ],
  "paging": {
    "cursors": {
      "before": "BEFORE_CURSOR",
      "after": "AFTER_CURSOR"
    }
  }
}';
}