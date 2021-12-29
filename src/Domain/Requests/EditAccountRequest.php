<?php

declare(strict_types=1);

namespace P7v\TelegraphApi\Domain\Requests;

use P7v\TelegraphApi\Domain\AccessToken;
use Webmozart\Assert\Assert;

/**
 * @psalm-immutable
 */
final class EditAccountRequest implements RequestInterface
{
    private AccessToken $accessToken;

    /** @var non-empty-string|null */
    private ?string $shortName = null;

    /** @var non-empty-string|null */
    private ?string $authorName = null;

    /** @var non-empty-string|null */
    private ?string $authorUrl = null;

    public function __construct(AccessToken $accessToken)
    {
        $this->accessToken = $accessToken;
    }

    public function withShortName(string $shortName): self
    {
        Assert::stringNotEmpty($shortName);
        Assert::maxLength($shortName, 32);

        $request = clone $this;

        $request->shortName = $shortName;

        return $request;
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
     * @internal
     */
    public function isEmpty(): bool
    {
        return is_null($this->shortName)
            && is_null($this->authorName)
            && is_null($this->authorUrl);
    }

    /**
     * @return array{access_token: non-empty-string, short_name?: non-empty-string, author_name?: non-empty-string, author_url?: non-empty-string}
     */
    public function getJson(): array
    {
        $json = [
            'access_token' => $this->accessToken->getValue(),
        ];

        if (!is_null($this->shortName)) {
            $json['short_name'] = $this->shortName;
        }

        if (!is_null($this->authorName)) {
            $json['author_name'] = $this->authorName;
        }

        if (!is_null($this->authorUrl)) {
            $json['author_url'] = $this->authorUrl;
        }

        return $json;
    }
}
