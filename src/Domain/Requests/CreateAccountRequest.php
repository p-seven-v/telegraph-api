<?php

declare(strict_types=1);

namespace P7v\TelegraphApi\Domain\Requests;

use Assert\Assert;
use Assert\LazyAssertionException;

final class CreateAccountRequest
{
    /** @var non-empty-string */
    private string $shortName;

    private string $authorName;

    private string $authorUrl;

    /**
     * @throws LazyAssertionException
     */
    public function __construct(string $shortName, string $authorName = '', string $authorUrl = '')
    {
        Assert::lazy()
            ->that($shortName)->notEmpty()->maxLength(32)
            ->that($authorName)->maxLength(128)
            ->that($authorUrl)->maxLength(512)
            ->verifyNow();

        $this->shortName = $shortName;
        $this->authorName = $authorName;
        $this->authorUrl = $authorUrl;
    }

    /**
     * @internal
     */
    public function getShortName(): string
    {
        return $this->shortName;
    }

    /**
     * @internal
     */
    public function getAuthorName(): string
    {
        return $this->authorName;
    }

    /**
     * @internal
     */
    public function getAuthorUrl(): string
    {
        return $this->authorUrl;
    }
}
