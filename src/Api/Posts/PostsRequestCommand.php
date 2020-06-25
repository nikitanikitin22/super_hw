<?php

declare(strict_types=1);

namespace Super\Api\Posts;

use Super\Api\Client;
use Super\Entity\PostCollection;
use Super\Entity\Token;
use Super\Mapper\PostCollectionMapper;

class PostsRequestCommand
{
    private PostCollectionMapper $postCollectionMapper;
    private Client $apiClient;

    public function __construct(PostCollectionMapper $postCollectionMapper, Client $apiClient)
    {
        $this->postCollectionMapper = $postCollectionMapper;
        $this->apiClient = $apiClient;
    }

    public function fetchMultiplePostPages(int $from, int $to, Token $token): PostCollection
    {
        $postCollection = new PostCollection();

        for ($page = $from; $page <= $to; $page++) {
            $postRequest = new PostsRequest($token, $page);

            $this->fetchPosts($postRequest, $postCollection);
        }

        return $postCollection;
    }

    public function fetchPosts(PostsRequest $postsRequest, ?PostCollection $postCollection = null): PostCollection
    {
        if ($postCollection === null) {
            $postCollection = new PostCollection();
        }

        $posts = $this->apiClient->getPosts($postsRequest);
        $body = json_decode($posts->getBody()->getContents(), true);
        $postsBody = $body['data']['posts'];
        $this->postCollectionMapper->map($postsBody, $postCollection);

        return $postCollection;
    }
}