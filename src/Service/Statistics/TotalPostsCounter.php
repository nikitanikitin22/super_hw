<?php

declare(strict_types=1);

namespace Super\Service\Statistics;

use Super\Entity\AggregatedPostsCollection;
use Super\Entity\AggregatedPosts;
use Super\Entity\Statistics;
use Super\Entity\StatisticsCollection;

class TotalPostsCounter implements StatisticsInterface
{
    private const NAME = 'Post count per timeunit (weeks for homework)';

    public function calculateStatistics(AggregatedPostsCollection $postsCollection): StatisticsCollection
    {
        $statisticsCollection = new StatisticsCollection(self::getName());

        foreach ($postsCollection->getAggregatedPosts() as $aggregatedPosts) {
            $statisticsCollection->addStatistics($this->countForAggregation($aggregatedPosts));
        }

        return $statisticsCollection;
    }

    private function countForAggregation(AggregatedPosts $aggregatedPosts): Statistics
    {
        return new Statistics($aggregatedPosts->getKey(), count($aggregatedPosts->getPostCollection()->getPosts()));
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
