<?php

declare(strict_types=1);

namespace Super\Entity;

class PostCollection
{
    private array $posts;

    public function __construct()
    {
        $this->posts = [];
    }

    public function addPost(Post $post): self
    {
        $this->posts[] = $post;

        return $this;
    }

    /**
     * @return Post[]
     */
    public function getPosts(): array
    {
        return $this->posts;
    }
}
