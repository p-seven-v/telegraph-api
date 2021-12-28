<?php

declare(strict_types=1);

namespace P7v\TelegraphApi\Domain\Requests;

use Assert\Assert;
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
        Assert::lazy()
            ->that($shortName)->notEmpty()->maxLength(32)
            ->that($authorName)->maxLength(128)
            ->that($authorUrl)->maxLength(512)
            ->verifyNow();

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
