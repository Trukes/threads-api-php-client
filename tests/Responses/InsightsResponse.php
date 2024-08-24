<?php
declare(strict_types=1);

namespace Tests\Responses;

final class InsightsResponse
{
    public const THREADS_METRIC_FULL_FORM_FIELDS = [
        'likes',
        'replies',
    ];

    public const THREADS_USERS_FULL_FORM_FIELDS = [
        'since' => 'since_date',
    ];

    public const THREADS_METRICS_FULL_RESPONSE = '{
  "data": [
    {
      "name": "likes",
      "period": "lifetime",
      "values": [
        {
          "value": 100
        }
      ],
      "title": "Likes",
      "description": "The number of likes on your post.",
      "id": "<media_id>/insights/likes/lifetime"
    },
    {
      "name": "replies",
      "period": "lifetime",
      "values": [
        {
          "value": 10
        }
      ],
      "title": "Replies",
      "description": "The number of replies on your post.",
      "id": "<media_id>/insights/replies/lifetime"
    }
  ]
}';

}