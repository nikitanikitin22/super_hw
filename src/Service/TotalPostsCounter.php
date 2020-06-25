<?php

declare(strict_types=1);

namespace Super\Service;

use Super\Entity\AggregatedPostsCollection;
use Super\Entity\AggregatedPosts;

class TotalPostsCounter
{
    public function count(AggregatedPostsCollection $postsCollection)
    {
        foreach ($postsCollection->getAggregatedPosts() as $aggregatedPosts) {
            $this->countForAggregation($aggregatedPosts);
        }
    }

    private function countForAggregation(AggregatedPosts $aggregatedPosts)
    {
        echo 'For ' . $aggregatedPosts->getKey() . ' total number of posts is ' . count($aggregatedPosts->getPostCollection()->getPosts()) . PHP_EOL;
    }
}