<?php

declare(strict_types=1);

namespace Super\Entity;

class AggregatedPostsCollection
{
    private array $aggregatedPosts;

    public function __construct()
    {
        $this->aggregatedPosts = [];
    }

    public function addAggregatedPosts(AggregatedPosts $aggregatedPosts)
    {
        $this->aggregatedPosts[] = $aggregatedPosts;
    }

    /**
     * @return AggregatedPosts[]
     */
    public function getAggregatedPosts(): array
    {
        return $this->aggregatedPosts;
    }
}