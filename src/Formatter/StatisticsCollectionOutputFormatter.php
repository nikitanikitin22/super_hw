<?php

declare(strict_types=1);

namespace Super\Formatter;

use Super\Entity\StatisticsCollection;

class StatisticsCollectionOutputFormatter
{
    public function format(StatisticsCollection $statisticsCollection): array
    {
        $output = [];
        $output['name'] = $statisticsCollection->getName();
        $output['data'] = [];

        foreach ($statisticsCollection->getStatistics() as $statistics) {
            $output['data'][] = [
                'timeUnit' => $statistics->getDataKey(),
                'value'    => $statistics->getData()
            ];
        }

        return $output;
    }
}
