<?php

declare(strict_types=1);

namespace Super\Mapper;

use Super\Entity\PostCollection;

class PostCollectionMapper
{
    private PostMapper $postMapper;

    public function __construct(PostMapper $postMapper)
    {
        $this->postMapper = $postMapper;
    }

    public function map(array $posts, PostCollection $collection): PostCollection
    {
        foreach ($posts as $post) {
            $mappedPost = $this->postMapper->map($post);
            $collection->addPost($mappedPost);
        }

        return $collection;
    }
}
