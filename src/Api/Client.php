<?php

declare(strict_types=1);

namespace Super\Api;

use GuzzleHttp\Client as Guzzle;
use Super\Api\Posts\PostsRequest;
use Super\Api\Posts\PostsResponse;
use Super\Api\Register\RegisterRequest;
use Super\Api\Register\RegisterResponse;

class Client
{
    private Guzzle $httpClient;

    public function __construct(Guzzle $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function register(RegisterRequest $request): RegisterResponse
    {

    }

    public function getPosts(PostsRequest $request): PostsResponse
    {

    }
}
