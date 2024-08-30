<?php

namespace Trukes\ThreadsApiPhpClient\Example;

require "vendor/autoload.php";

use Trukes\ThreadsApiPhpClient\Threads;


$client = Threads::client('<your_token_here>');
$create = $client->publish()->create(
    'threads_user_id',
    'media_type',
    'text',
    'image_url',
    'video_url',
    true,
    ['children'],
    'reply_to_id',
    'reply_control',
    ['allowlisted_country_codes'],
    'all_text',
);

var_dump($create);
