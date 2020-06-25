<?php

declare(strict_types=1);

namespace Super\Entity;

class AggregatedPosts
{
    private string $key;
    private PostCollection $postCollection;

    public function __construct(string $key, PostCollection $postCollection)
    {
        $this->key = $key;
        $this->postCollection = $postCollection;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getPostCollection(): PostCollection
    {
        return $this->postCollection;
    }
}
