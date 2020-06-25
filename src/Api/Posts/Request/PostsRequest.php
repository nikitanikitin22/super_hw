<?php

declare(strict_types=1);

namespace Super\Api\Posts\Request;

use Super\Api\Register\Response\Token;

class PostsRequest
{
    private Token $token;
    private int $page;

    public function __construct(Token $token, int $page)
    {
        $this->token = $token;
        $this->page = $page;
    }

    public function getToken(): Token
    {
        return $this->token;
    }

    public function getPage(): int
    {
        return $this->page;
    }
}
