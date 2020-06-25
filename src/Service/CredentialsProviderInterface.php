<?php

declare(strict_types=1);

namespace Super\Service;

interface CredentialsProviderInterface
{
    public function getClientId(): string;
    public function getEmail(): string;
    public function getName(): string;
}
