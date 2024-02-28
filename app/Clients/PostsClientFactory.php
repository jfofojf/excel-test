<?php

namespace App\Clients;
class PostsClientFactory
{
    public static function create(array $config = []): PostsClient
    {
        $config = array_merge(
            [
                'base_uri' => PostsClient::BASE_URL,
            ],
            $config
        );

        return new PostsClient($config);
    }
}
