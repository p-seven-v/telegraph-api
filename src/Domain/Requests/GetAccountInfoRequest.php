<?php

declare(strict_types=1);

namespace P7v\TelegraphApi\Domain\Requests;

use P7v\TelegraphApi\Domain\AccessToken;

final class GetAccountInfoRequest implements RequestInterface
{
    private AccessToken $accessToken;

    public function __construct(AccessToken $accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * @return array{access_token: non-empty-string}
     */
    public function getJson(): array
    {
        return [
            'access_token' => $this->accessToken->getValue(),
        ];
    }
}
