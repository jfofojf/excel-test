<?php

namespace App\Clients;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;

class PostsClient extends Client
{
    public const BASE_URL = 'https://techcrunch.com';
    protected const POSTS_URL = '/wp-json/wp/v2/posts';

    /**
     * @throws GuzzleException
     */
    public function getPosts(int $pageNumber, int $perPage): array
    {
        $query = [
            'per_page' => $perPage,
            'page' => $pageNumber,
        ];

        $response = $this->get(self::POSTS_URL, [RequestOptions::QUERY => $query]);
        $content = $response->getBody()->getContents();

        return json_decode($content, true);
    }
}
