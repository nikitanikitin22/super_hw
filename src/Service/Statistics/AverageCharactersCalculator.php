<?php

declare(strict_types=1);

namespace Super\Service\Statistics;

use Super\Entity\AggregatedPosts;
use Super\Entity\AggregatedPostsCollection;
use Super\Entity\Statistics;
use Super\Entity\StatisticsCollection;

class AverageCharactersCalculator implements StatisticsInterface
{
    private const NAME = 'Average characters per post per timeunit (months for homework)';

    public function calculateStatistics(AggregatedPostsCollection $postsCollection): StatisticsCollection
    {
        $statisticsCollection = new StatisticsCollection(self::getName());

        foreach ($postsCollection->getAggregatedPosts() as $aggregatedPosts) {
            $statisticsCollection->addStatistics($this->calculateAverageForAggregation($aggregatedPosts));
        }

        return $statisticsCollection;
    }

    private function calculateAverageForAggregation(AggregatedPosts $aggregatedPosts): Statistics
    {
        $characters = 0;
        $posts = $aggregatedPosts->getPostCollection()->getPosts();

        foreach ($posts as $post) {
            $characters+= strlen($post->getMessage());
        }

        return new Statistics($aggregatedPosts->getKey(), $characters/count($posts));
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
