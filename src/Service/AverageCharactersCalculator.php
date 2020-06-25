<?php

declare(strict_types=1);

namespace Super\Service;

use Super\Entity\AggregatedPosts;
use Super\Entity\AggregatedPostsCollection;

class AverageCharactersCalculator
{
    public function calculate(AggregatedPostsCollection $postsCollection)
    {
        foreach ($postsCollection->getAggregatedPosts() as $aggregatedPosts) {
            $this->calculateAverageForAggregation($aggregatedPosts);
        }
    }

    private function calculateAverageForAggregation(AggregatedPosts $aggregatedPosts)
    {
        $characters = 0;
        $posts = $aggregatedPosts->getPostCollection()->getPosts();

        foreach ($posts as $post) {
            $characters+= strlen($post->getMessage());
        }

        echo 'For ' . $aggregatedPosts->getKey() . ' average character count is: ' . $characters/count($posts) . PHP_EOL;
    }
}