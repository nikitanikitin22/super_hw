<?php

declare(strict_types=1);

namespace Super\Api\Register;

use Super\Api\Client;
use Super\Entity\Credentials;
use Super\Entity\Token;
use Super\Mapper\TokenMapper;
use Super\Service\CredentialsProviderInterface;

class RegisterRequestCommand
{
    private CredentialsProviderInterface $credentialsProvider;
    private Client $apiClient;
    private TokenMapper $tokenMapper;

    public function __construct(
        CredentialsProviderInterface $credentialsProvider,
        Client $apiClient,
        TokenMapper $tokenMapper
    ) {
        $this->credentialsProvider = $credentialsProvider;
        $this->apiClient = $apiClient;
        $this->tokenMapper = $tokenMapper;
    }

    public function getToken(): Token
    {
        $credentials = new Credentials(
            $this->credentialsProvider->getClientId(),
            $this->credentialsProvider->getEmail(),
            $this->credentialsProvider->getName(),
        );

        $response = $this->apiClient->register($credentials);

        return $this->tokenMapper->map($response);
    }
}
