<?php

declare(strict_types=1);

namespace Super\Service\Statistics;

use Super\Entity\AggregatedPostsCollection;
use Super\Entity\StatisticsCollection;

interface StatisticsInterface
{
    public function calculateStatistics(AggregatedPostsCollection $postsCollection): StatisticsCollection;

    public function getName(): string;
}
