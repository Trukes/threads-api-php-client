<?php
declare(strict_types=1);

namespace Tests\Responses;

final class ReplyManagementResponse
{
    public const THREADS_REPLIES_FULL_FIELDS = [
        'id',
        'text',
        'username',
        'permalink',
        'timestamp',
        'media_product_type',
        'media_type',
        'media_url',
        'shortcode',
        'thumbnail_url',
        'children',
        'is_quote_post',
        'has_replies',
        'root_post',
        'replied_to',
        'is_reply',
        'is_reply_owned_by_me',
        'hide_status',
        'reply_audience',
    ];

    public const THREADS_REPLIES_FULL_RESPONSE = '{
  "data": [
    {
      "id": "1234567890",
      "text": "First Reply",
      "timestamp": "2024-01-01T18:20:00+0000",
      "media_product_type": "THREADS",
      "media_type": "TEXT_POST",
      "shortcode": "abcdefg",
      "has_replies": true,
      "root_post": {
        "id": "1234567890"
      },
      "replied_to": {
        "id": "1234567890"
      },
      "is_reply": true,
      "hide_status": "NOT_HUSHED"
    },
    {
      "id": "1234567890",
      "text": "Second Reply",
      "timestamp": "2024-01-01T18:20:00+0000",
      "media_product_type": "THREADS",
      "media_type": "TEXT_POST",
      "shortcode": "abcdefg",
      "has_replies": false,
      "root_post": {
        "id": "1234567890"
      },
      "replied_to": {
        "id": "1234567890"
      },
      "is_reply": true,
      "hide_status": "HIDDEN"
    },
    {
      "id": "1234567890",
      "text": "Third Reply",
      "timestamp": "2024-01-01T18:20:00+0000",
      "media_product_type": "THREADS",
      "media_type": "TEXT_POST",
      "shortcode": "abcdefg",
      "has_replies": false,
      "root_post": {
        "id": "1234567890"
      },
      "replied_to": {
        "id": "1234567890"
      },
      "is_reply": true,
      "hide_status": "UNHUSHED"
    }
  ],
  "paging": {
    "cursors": {
      "before": "BEFORE_CURSOR",
      "after": "AFTER_CURSOR"
    }
  }
}';

    public const THREADS_REPLIES_HALF_FIELDS = [
        'id',
        'text',
    ];

    public const THREADS_REPLIES_HALF_RESPONSE =
        '{
  "data": [
    {
      "id": "1234567890",
      "text": "First Reply"
    },
    {
      "id": "1234567890",
      "text": "Second Reply"
    },
    {
      "id": "1234567890",
      "text": "Third Reply"
    }
  ],
  "paging": {
    "cursors": {
      "before": "BEFORE_CURSOR",
      "after": "AFTER_CURSOR"
    }
  }
}';

    public const THREADS_CONVERSATION_FULL_FIELDS = [
        'id',
        'text',
        'timestamp',
        'media_product_type',
        'media_type',
        'shortcode',
        'has_replies',
        'root_post',
        'replied_to',
        'is_reply',
        'hide_status',
    ];

    public const THREADS_CONVERSATION_FULL_RESPONSE = '{
  "data": [
    {
      "id": "1234567890",
      "text": "First Reply",
      "timestamp": "2024-01-01T18:20:00+0000",
      "media_product_type": "THREADS",
      "media_type": "TEXT_POST",
      "shortcode": "abcdefg",
      "has_replies": true,
      "root_post": {
        "id": "1234567890"
      },
      "replied_to": {
        "id": "1234567890"
      },
      "is_reply": true,
      "hide_status": "NOT_HUSHED"
    },
    {
      "id": "1234567890",
      "text": "Second Reply",
      "timestamp": "2024-01-01T18:20:00+0000",
      "media_product_type": "THREADS",
      "media_type": "TEXT_POST",
      "shortcode": "abcdefg",
      "has_replies": false,
      "root_post": {
        "id": "1234567890"
      },
      "replied_to": {
        "id": "1234567890"
      },
      "is_reply": true,
      "hide_status": "HIDDEN"
    },
    {
      "id": "1234567890",
      "text": "Third Reply",
      "timestamp": "2024-01-01T18:20:00+0000",
      "media_product_type": "THREADS",
      "media_type": "TEXT_POST",
      "shortcode": "abcdefg",
      "has_replies": false,
      "root_post": {
        "id": "1234567890"
      },
      "replied_to": {
        "id": "1234567890"
      },
      "is_reply": true,
      "hide_status": "UNHUSHED"
    }
  ],
  "paging": {
    "cursors": {
      "before": "BEFORE_CURSOR",
      "after": "AFTER_CURSOR"
    }
  }
}';


    public const THREADS_CONVERSATION_HALF_FIELDS = [
        'root_post',
    ];

    public const THREADS_CONVERSATION_HALF_RESPONSE = '{
  "data": [
    {
      "root_post": {
        "id": "1234567890"
      }
    },
    {
      "root_post": {
        "id": "1234567890"
      }
    },
    {
      "root_post": {
        "id": "1234567890"
      }
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