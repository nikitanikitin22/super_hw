<?php

require 'vendor/autoload.php';

try {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
    $dotenv->required(['API_CLIENT_ID', 'API_EMAIL', 'API_NAME']);
} catch (\Dotenv\Exception\ExceptionInterface $exception) {
    echo $exception->getMessage();
}
