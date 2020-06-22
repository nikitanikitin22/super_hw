<?php

declare(strict_types=1);

namespace Super\Api\Posts;

class PostsRequest
{
    private string $token;
    private int $page;

    public function __construct(string $token, int $page)
    {
        $this->token = $token;
        $this->page = $page;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getPage(): int
    {
        return $this->page;
    }
}
