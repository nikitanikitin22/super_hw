<?php

declare(strict_types=1);

namespace Super\Service;

class EnvCredentialsProvider implements CredentialsProviderInterface
{
    public function getClientId(): string
    {
        return $_ENV['API_CLIENT_ID'];
    }

    public function getEmail(): string
    {
        return $_ENV['API_EMAIL'];
    }

    public function getName(): string
    {
        return $_ENV['API_NAME'];
    }
}
