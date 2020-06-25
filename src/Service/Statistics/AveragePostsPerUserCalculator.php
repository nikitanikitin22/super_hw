<?php

declare(strict_types=1);

namespace Super\Service\Statistics;

use Super\Entity\AggregatedPosts;
use Super\Entity\AggregatedPostsCollection;
use Super\Entity\Statistics;
use Super\Entity\StatisticsCollection;

class AveragePostsPerUserCalculator implements StatisticsInterface
{
    private const NAME = 'Average number of posts per user per timeunit (months for homework)';

    public function calculateStatistics(AggregatedPostsCollection $postsCollection): StatisticsCollection
    {
        $totalMap = [];

        foreach ($postsCollection->getAggregatedPosts() as $aggregatedPosts) {
            $monthlyPostsMap = $this->calculateAverageForAggregation($aggregatedPosts);

            foreach ($monthlyPostsMap as $userId => $postCount) {
                if (!isset($totalMap[$userId])) {
                    $totalMap[$userId] = $postCount;
                } else {
                    $totalMap[$userId] += $postCount;
                }
            }
        }

        $statisticsCollection = new StatisticsCollection(self::getName());
        $timeUnitCount = count($postsCollection->getAggregatedPosts());

        foreach ($totalMap as $key => $value) {
            $statisticsCollection->addStatistics(new Statistics($key, $value / $timeUnitCount));
        }

        return $statisticsCollection;
    }

    private function calculateAverageForAggregation(AggregatedPosts $aggregatedPosts)
    {
        $userPostsMap = [];
        $posts = $aggregatedPosts->getPostCollection()->getPosts();

        foreach ($posts as $post) {
            if (!isset($userPostsMap[$post->getUserId()])) {
                $userPostsMap[$post->getUserId()] = 1;
            } else {
                $userPostsMap[$post->getUserId()]++;
            }
        }

        return $userPostsMap;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
