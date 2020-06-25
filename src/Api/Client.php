<?php

declare(strict_types=1);

namespace Super\Api;

use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use Super\Api\Posts\PostsRequest;
use Super\Api\Posts\PostsResponse;
use Super\Api\Register\Request\Credentials;
use Super\Api\Register\RegisterResponse;

class Client
{
    public const BASE_URL = 'https://api.supermetrics.com';
    private const REGISTER = '/assignment/register';
    private const POSTS = '/assignment/posts';

    private const DEFAULT_ERROR = 'Something went wrong';

    private Guzzle $httpClient;

    public function __construct(Guzzle $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function register(Credentials $credentials): ResponseInterface
    {
        try {
            $response = $this->httpClient->request('POST', self::REGISTER, [
                'json' => [
                    'client_id' => $credentials->getClientId(),
                    'email'     => $credentials->getEmail(),
                    'name'      => $credentials->getName(),
                ]
            ]);
        } catch (GuzzleException $exception) {
            throw new ApiException($exception->getMessage());
        }

        //I expect all bad responses to have proper error codes,
        // still putting this here in case of error without 4XX/5XX status code.
        if ($response->getStatusCode() !== 200) {
            $body = json_decode($response->getBody()->getContents(), true);

            $error = isset($body['error']['message']) ? $body['error']['message'] : self::DEFAULT_ERROR;

            throw new ApiException($error);
        }

        return $response;
    }

    public function getPosts(PostsRequest $request): PostsResponse
    {

    }
}
