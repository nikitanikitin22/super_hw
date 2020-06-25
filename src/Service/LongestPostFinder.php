<?php

declare(strict_types=1);

namespace Super\Service;

use Super\Entity\AggregatedPosts;
use Super\Entity\AggregatedPostsCollection;

class LongestPostFinder
{
    public function find(AggregatedPostsCollection $postsCollection)
    {
        foreach ($postsCollection->getAggregatedPosts() as $aggregatedPosts) {
            $this->findLongestPostInAggregation($aggregatedPosts);
        }
    }

    private function findLongestPostInAggregation(AggregatedPosts $aggregatedPosts)
    {
        $posts = $aggregatedPosts->getPostCollection()->getPosts();
        $longestPost = reset($posts);

        foreach ($posts as $post) {
            if (strlen($post->getMessage()) > strlen($longestPost->getMessage())) {
                $longestPost = $post;
            }
        }

        echo 'Longest post for ' . $aggregatedPosts->getKey() . ' is post with ID: ' .
            $longestPost->getId() . ' and length of ' . strlen($longestPost->getMessage()) . PHP_EOL;
    }
}
