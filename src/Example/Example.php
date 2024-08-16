<?php

namespace Trukes\ThreadsApiPhpClient\Example;


use Trukes\ThreadsApiPhpClient\Threads;

class Example
{
    public static function post()
    {
        /*$client = new Client();
        $client->authenticate([]);

            $client
                ->posts('thread-user-id')
                ->singlePost()
                ->createContainer()
                ->publishContainer();


        $client->posts()->singleThreadPosts();*/

        $client = Threads::client('token');

        $client->posts()
            ->createMediaContainer();

    }
}