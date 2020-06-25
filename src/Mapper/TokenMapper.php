<?php

declare(strict_types=1);

namespace Super\Mapper;

use Psr\Http\Message\ResponseInterface;
use Super\Api\ApiException;
use Super\Entity\Token;

class TokenMapper
{
    public function map(ResponseInterface $response): Token
    {
        $body = json_decode($response->getBody()->getContents(), true);

        if (!isset($body['data'], $body['data']['client_id'], $body['data']['email'], $body['data']['sl_token'])) {
            throw new ApiException('Missing required keys in register response');
        }

        return new Token($body['data']['client_id'], $body['data']['email'], $body['data']['sl_token']);
    }
}
