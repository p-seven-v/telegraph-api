<?php

declare(strict_types=1);

namespace P7v\TelegraphApi\Domain\Requests;

use Assert\Assertion;
use Assert\AssertionFailedException;

final class CreateAccountRequest implements RequestInterface
{
    /** @var non-empty-string */
    private string $shortName;

    private string $authorName;

    private string $authorUrl;

    /**
     * @throws AssertionFailedException
     */
    public function __construct(string $shortName, string $authorName = '', string $authorUrl = '')
    {
        Assertion::notEmpty($shortName);
        Assertion::maxLength($shortName, 32);
        Assertion::maxLength($authorName, 128);
        Assertion::maxLength($authorUrl, 512);

        $this->shortName = $shortName;
        $this->authorName = $authorName;
        $this->authorUrl = $authorUrl;
    }

    /**
     * @return array{short_name: non-empty-string, author_name?: string, author_url?: string}
     */
    public function getJson(): array
    {
        return array_merge(
            [
                'short_name' => $this->shortName,
            ],
            array_filter(
                [
                    'author_name' => $this->authorName,
                    'author_url' => $this->authorUrl,
                ]
            )
        );
    }
}
