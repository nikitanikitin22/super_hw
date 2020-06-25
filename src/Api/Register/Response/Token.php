<?php

declare(strict_types=1);

namespace Super\Api\Register\Response;

class Token
{
    private string $clientId;
    private string $email;
    private string $slToken;

    public function __construct(string $clientId, string $email, string $slToken)
    {
        $this->clientId = $clientId;
        $this->email = $email;
        $this->slToken = $slToken;
    }

    public function getClientId(): string
    {
        return $this->clientId;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getSlToken(): string
    {
        return $this->slToken;
    }
}
