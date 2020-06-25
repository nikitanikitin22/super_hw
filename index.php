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

    $aggregator = new \Super\Service\Aggregator();

    $postsPerMonth = $aggregator->aggregateByMonths($posts);
    $averageCharsPerMonth = (new \Super\Service\Statistics\AverageCharactersCalculator())->calculateStatistics($postsPerMonth);
    $longestPostPerMonth = (new \Super\Service\Statistics\LongestPostFinder())->calculateStatistics($postsPerMonth);
    $averagePostPerUserPerMonth = (new \Super\Service\Statistics\AveragePostsPerUserCalculator())->calculateStatistics($postsPerMonth);

    $postsPerWeek = $aggregator->aggregateByWeeks($posts);

    $totalPostsPerWeek = (new \Super\Service\Statistics\TotalPostsCounter())->calculateStatistics($postsPerWeek);

    $formatter = new \Super\Formatter\StatisticsCollectionOutputFormatter();

    $output = [
        $formatter->format($averageCharsPerMonth),
        $formatter->format($longestPostPerMonth),
        $formatter->format($averagePostPerUserPerMonth),
        $formatter->format($totalPostsPerWeek),
    ];

    //Probably needs to be replaced with a class as well
    echo json_encode($output, JSON_PRETTY_PRINT);

} catch (\Super\Api\ApiException $exception) {
    echo $exception->getMessage();
}
