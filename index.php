<?php

require 'vendor/autoload.php';

try {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
    $dotenv->required(['API_CLIENT_ID', 'API_EMAIL', 'API_NAME']);
} catch (\Dotenv\Exception\ExceptionInterface $exception) {
    echo $exception->getMessage();
}

//Credentials build
$credentialsProvider = new \Super\Service\EnvCredentialsProvider();
$credentials = new \Super\Api\Register\Request\Credentials(
    $credentialsProvider->getClientId(),
    $credentialsProvider->getEmail(),
    $credentialsProvider->getName(),
);

//Api client build
$apiClient = new \Super\Api\Client(new \GuzzleHttp\Client([
    'base_uri' => \Super\Api\Client::BASE_URL
]));

try {
    //Register request and token creation
    $response = $apiClient->register($credentials);
    $token = (new \Super\Api\Register\Mapper\TokenMapper())->map($response);

    //Posts fetch and map
    $postMapper = new \Super\Mapper\PostCollectionMapper(new \Super\Mapper\PostMapper());
    $postsCollection = new \Super\Entity\PostCollection();

    for ($i = 1; $i <= 10; $i++) {
        $postRequest = new \Super\Api\Posts\Request\PostsRequest($token, $i);
        $posts = $apiClient->getPosts($postRequest);
        $body = json_decode($posts->getBody()->getContents(), true);
        $postsBody = $body['data']['posts'];

        $postMapper->map($postsBody, $postsCollection);
    }

} catch (\Super\Api\ApiException $exception) {
    echo $exception->getMessage();
}
