<?php

declare(strict_types=1);

namespace Super\Aggregator;

use Super\Entity\AggregatedPosts;
use Super\Entity\AggregatedPostsCollection;
use Super\Entity\PostCollection;

class MonthlyAggregator
{
    public function makeFromCollection(PostCollection $collection): AggregatedPostsCollection
    {
        $aggregator = new AggregatedPostsCollection();
        $monthlyCollection = new PostCollection();
        $previousMonth = $collection->getPosts()[0]->getCreatedAt()->format('Y-m');

        foreach ($collection->getPosts() as $post) {
            if ($post->getCreatedAt()->format('Y-m') !== $previousMonth) {
                $aggregator->addAggregatedPosts(new AggregatedPosts($previousMonth, $monthlyCollection));
                $monthlyCollection = new PostCollection();
                $previousMonth = $post->getCreatedAt()->format('Y-m');
            } else {
                $monthlyCollection->addPost($post);
            }
        }

        if (count($monthlyCollection->getPosts()) > 0) {
            $aggregator->addAggregatedPosts(new AggregatedPosts($previousMonth, $monthlyCollection));
        }

        return $aggregator;
    }
}