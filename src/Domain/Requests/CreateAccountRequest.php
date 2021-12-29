<?php

declare(strict_types=1);

namespace P7v\TelegraphApi\Domain\Requests;

use Webmozart\Assert\Assert;

/**
 * @psalm-immutable
 */
final class CreateAccountRequest implements RequestInterface
{
    /** @var non-empty-string */
    private string $shortName;

    /** @var non-empty-string|null */
    private ?string $authorName = null;

    /** @var non-empty-string|null */
    private ?string $authorUrl = null;

    public function __construct(string $shortName)
    {
        Assert::stringNotEmpty($shortName);
        Assert::maxLength($shortName, 32);

        $this->shortName = $shortName;
    }

    public function withAuthorName(string $authorName): self
    {
        Assert::stringNotEmpty($authorName);
        Assert::maxLength($authorName, 128);

        $request = clone $this;

        $request->authorName = $authorName;

        return $request;
    }

    public function withAuthorUrl(string $authorUrl): self
    {
        Assert::stringNotEmpty($authorUrl);
        Assert::maxLength($authorUrl, 512);

        $request = clone $this;

        $request->authorUrl = $authorUrl;

        return $request;
    }

    /**
     * @return array{short_name: non-empty-string, author_name?: non-empty-string, author_url?: non-empty-string}
     */
    public function getJson(): array
    {
        $json = [
            'short_name' => $this->shortName,
        ];

        if (!is_null($this->authorName)) {
            $json['author_name'] = $this->authorName;
        }

        if (!is_null($this->authorUrl)) {
            $json['author_url'] = $this->authorUrl;
        }

        return $json;
    }
}
