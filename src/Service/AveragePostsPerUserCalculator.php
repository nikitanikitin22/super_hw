<?php

declare(strict_types=1);

namespace Super\Service;

use Super\Entity\AggregatedPosts;
use Super\Entity\AggregatedPostsCollection;

class AveragePostsPerUserCalculator
{
    public function calculate(AggregatedPostsCollection $postsCollection)
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

        $timeUnitCount = count($postsCollection->getAggregatedPosts());

        foreach ($totalMap as $key => $value) {
            echo 'Average post count for user ' . $key . ' is ' . $value/$timeUnitCount . PHP_EOL;
        }
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
}