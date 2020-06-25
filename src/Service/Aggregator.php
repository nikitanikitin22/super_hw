<?php

declare(strict_types=1);

namespace Super\Service;

use Super\Entity\AggregatedPosts;
use Super\Entity\AggregatedPostsCollection;
use Super\Entity\PostCollection;

class Aggregator
{
    private const MONTH_FORMAT = 'Y-m';
    private const WEEK_FORMAT = 'o-W';

    public function aggregateByWeeks(PostCollection $postCollection): AggregatedPostsCollection
    {
        return $this->makeFromCollection($postCollection, self::WEEK_FORMAT);
    }

    public function aggregateByMonths(PostCollection $postCollection): AggregatedPostsCollection
    {
        return $this->makeFromCollection($postCollection, self::MONTH_FORMAT);
    }

    private function makeFromCollection(PostCollection $collection, string $format): AggregatedPostsCollection
    {
        $aggregator = new AggregatedPostsCollection();
        $monthlyCollection = new PostCollection();
        $previousMonth = $collection->getPosts()[0]->getCreatedAt()->format($format);

        foreach ($collection->getPosts() as $post) {
            if ($post->getCreatedAt()->format($format) !== $previousMonth) {
                $aggregator->addAggregatedPosts(new AggregatedPosts($previousMonth, $monthlyCollection));
                $monthlyCollection = new PostCollection();
                $previousMonth = $post->getCreatedAt()->format($format);
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