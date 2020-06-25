<?php

require 'vendor/autoload.php';

try {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
    $dotenv->required(['API_CLIENT_ID', 'API_EMAIL', 'API_NAME']);
} catch (\Dotenv\Exception\ExceptionInterface $exception) {
    echo $exception->getMessage();
}


$credentialsProvider = new \Super\Service\EnvCredentialsProvider();
$credentials = new \Super\Api\Register\Request\Credentials(
    $credentialsProvider->getClientId(),
    $credentialsProvider->getEmail(),
    $credentialsProvider->getName(),
);

$apiClient = new \Super\Api\Client(new \GuzzleHttp\Client([
    'base_uri' => \Super\Api\Client::BASE_URL
]));

try {
    $response = $apiClient->register($credentials);
    $token = (new \Super\Api\Register\Mapper\TokenMapper())->map($response);

} catch (\Super\Api\ApiException $exception) {
    echo $exception->getMessage();
}
