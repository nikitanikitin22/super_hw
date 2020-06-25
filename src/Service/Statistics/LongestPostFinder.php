<?php

declare(strict_types=1);

namespace Super\Service\Statistics;

use Super\Entity\AggregatedPosts;
use Super\Entity\AggregatedPostsCollection;
use Super\Entity\Statistics;
use Super\Entity\StatisticsCollection;
use function GuzzleHttp\Psr7\str;

class LongestPostFinder implements StatisticsInterface
{
    private const NAME = 'Longest post for timeunit (months for homework)';

    public function calculateStatistics(AggregatedPostsCollection $postsCollection): StatisticsCollection
    {
        $statisticsCollection = new StatisticsCollection(self::getName());

        foreach ($postsCollection->getAggregatedPosts() as $aggregatedPosts) {
            $statisticsCollection->addStatistics($this->findLongestPostInAggregation($aggregatedPosts));
        }

        return $statisticsCollection;
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

        return new Statistics($aggregatedPosts->getKey(), [
            'postId' => $longestPost->getId(),
            'length' => strlen($longestPost->getMessage())
        ]);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
