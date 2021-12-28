<?php

declare(strict_types=1);

namespace P7v\TelegraphApi\Domain\Requests;

use Assert\Assertion;
use P7v\TelegraphApi\Domain\AccessToken;

final class EditAccountRequest implements RequestInterface
{
    private AccessToken $accessToken;

    /** @var non-empty-string */
    private string $shortName;

    private string $authorName;

    private string $authorUrl;

    public function __construct(
        AccessToken $accessToken,
        string $shortName,
        string $authorName = '',
        string $authorUrl = ''
    ) {
        Assertion::notEmpty($shortName);
        Assertion::maxLength($shortName, 32);
        Assertion::maxLength($authorName, 128);
        Assertion::maxLength($authorUrl, 512);

        $this->accessToken = $accessToken;
        $this->shortName = $shortName;
        $this->authorName = $authorName;
        $this->authorUrl = $authorUrl;
    }

    /**
     * @return array{access_token: non-empty-string, short_name: non-empty-string, author_name?: string, author_url?: string}
     */
    public function getJson(): array
    {
        return array_filter(
            [
                'access_token' => $this->accessToken->getValue(),
                'short_name' => $this->shortName,
                'author_name' => $this->authorName,
                'author_url' => $this->authorUrl,
            ]
        );
    }
}
