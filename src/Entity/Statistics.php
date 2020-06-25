<?php

declare(strict_types=1);

namespace Super\Entity;

class Statistics
{
    private string $dataKey;
    private $data;

    public function __construct(string $dataKey, $data)
    {
        $this->dataKey = $dataKey;
        $this->data = $data;
    }

    public function getDataKey(): string
    {
        return $this->dataKey;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }
}
