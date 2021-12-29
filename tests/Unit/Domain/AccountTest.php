<?php

declare(strict_types=1);

namespace Tests\Unit\Domain;

use P7v\TelegraphApi\Domain\AccessToken;
use P7v\TelegraphApi\Domain\Account;
use PHPUnit\Framework\TestCase;

/**
 * @covers \P7v\TelegraphApi\Domain\Account
 */
class AccountTest extends TestCase
{
    /** @test */
    public function it_can_be_created_from_api_response(): void
    {
        $shortName = 'short name';
        $authorName = 'author';
        $authorUrl = 'https://example.com';
        $accessToken = 'token';
        $authUrl = 'https://example.com/auth';
        $pageCount = 13;

        $sut = Account::fromApiResponse(
            [
                'short_name' => $shortName,
                'author_name' => $authorName,
                'author_url' => $authorUrl,
                'access_token' => $accessToken,
                'auth_url' => $authUrl,
                'page_count' => $pageCount,
            ],
        );

        $this->assertEquals(new AccessToken($accessToken), $sut->getAccessToken());

        $this->assertSame($shortName, $sut->getShortName());
        $this->assertSame($authorName, $sut->getAuthorName());
        $this->assertSame($authorUrl, $sut->getAuthorUrl());
        $this->assertSame($authUrl, $sut->getAuthUrl());
        $this->assertSame($pageCount, $sut->getPageCount());
    }

    /** @test */
    public function it_can_be_created_empty(): void
    {
        $sut = Account::fromApiResponse(
            [
                'short_name' => null,
                'author_name' => null,
                'author_url' => null,
                'access_token' => null,
                'auth_url' => null,
                'page_count' => null,
            ],
        );

        $this->assertNull($sut->getAccessToken());
        $this->assertNull($sut->getShortName());
        $this->assertNull($sut->getAuthorName());
        $this->assertNull($sut->getAuthorUrl());
        $this->assertNull($sut->getAuthUrl());
        $this->assertNull($sut->getPageCount());
    }
}
