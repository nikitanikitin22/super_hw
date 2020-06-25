<?php

require 'vendor/autoload.php';

try {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
    $dotenv->required(['API_CLIENT_ID', 'API_EMAIL', 'API_NAME']);
} catch (\Dotenv\Exception\ExceptionInterface $exception) {
    echo $exception->getMessage();
}

//Build register request
$credentialsProvider = new \Super\Service\EnvCredentialsProvider();
$apiClient = new \Super\Api\Client(new \GuzzleHttp\Client([
    'base_uri' => \Super\Api\Client::BASE_URL
]));
$tokenMapper = new \Super\Mapper\TokenMapper();
$registerRequest = new \Super\Api\Register\RegisterRequestCommand($credentialsProvider, $apiClient, $tokenMapper);



$postRequestsCommand = new \Super\Api\Posts\PostsRequestCommand(
    new \Super\Mapper\PostCollectionMapper(new \Super\Mapper\PostMapper()),
    $apiClient
);


try {
    $token = $registerRequest->getToken();
    $posts = $postRequestsCommand->fetchMultiplePostPages(1, 10, $token);

    $monthlyAggregator = new \Super\Aggregator\MonthlyAggregator();

    $postsPerMonth = $monthlyAggregator->makeFromCollection($posts);
    (new \Super\Service\AverageCharactersCalculator())->calculate($postsPerMonth);
    (new \Super\Service\LongestPostFinder())->find($postsPerMonth);
    (new \Super\Service\AveragePostsPerUserCalculator())->calculate($postsPerMonth);

} catch (\Super\Api\ApiException $exception) {
    echo $exception->getMessage();
}
