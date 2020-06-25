<?php

declare(strict_types=1);

namespace Super\Entity;

class StatisticsCollection
{
    private string $name;
    private array $statistics;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->statistics = [];
    }

    public function addStatistics(Statistics $statistics): self
    {
        $this->statistics[] = $statistics;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Statistics[]
     */
    public function getStatistics(): array
    {
        return $this->statistics;
    }
}
