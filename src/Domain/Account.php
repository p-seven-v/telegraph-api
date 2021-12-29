<?php

declare(strict_types=1);

namespace P7v\TelegraphApi\Domain;

final class Account
{
    private ?string $shortName;

    private ?string $authorName;

    private ?string $authorUrl;

    private ?AccessToken $accessToken;

    private ?string $authUrl;

    private ?int $pageCount;

    private function __construct(
        ?string $shortName,
        ?string $authorName,
        ?string $authorUrl,
        ?AccessToken $accessToken,
        ?string $authUrl,
        ?int $pageCount
    ) {
        $this->shortName = $shortName;
        $this->authorName = $authorName;
        $this->authorUrl = $authorUrl;
        $this->accessToken = $accessToken;
        $this->authUrl = $authUrl;
        $this->pageCount = $pageCount;
    }

    /**
     * @param array{short_name?: string, author_name?: string, author_url?: string, access_token?: string, auth_url?: string, page_count?: int} $response
     *
     * @internal
     */
    public static function fromApiResponse(array $response): self
    {
        return new self(
            $response['short_name'] ?? null,
            $response['author_name'] ?? null,
            $response['author_url'] ?? null,
            self::createAccessToken($response['access_token'] ?? null),
            $response['auth_url'] ?? null,
            $response['page_count'] ?? null,
        );
    }

    public function getShortName(): ?string
    {
        return $this->shortName;
    }

    public function getAuthorName(): ?string
    {
        return $this->authorName;
    }

    public function getAuthorUrl(): ?string
    {
        return $this->authorUrl;
    }

    public function getAccessToken(): ?AccessToken
    {
        return $this->accessToken;
    }

    public function getAuthUrl(): ?string
    {
        return $this->authUrl;
    }

    public function getPageCount(): ?int
    {
        return $this->pageCount;
    }

    private static function createAccessToken(?string $accessToken): ?AccessToken
    {
        if (!is_null($accessToken)) {
            return new AccessToken($accessToken);
        }

        return null;
    }
}
