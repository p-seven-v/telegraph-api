<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Requests;

use InvalidArgumentException;
use P7v\TelegraphApi\Domain\AccessToken;
use P7v\TelegraphApi\Domain\Requests\EditAccountRequest;
use PHPUnit\Framework\TestCase;

/**
 * @covers \P7v\TelegraphApi\Domain\Requests\EditAccountRequest
 */
class EditAccountRequestTest extends TestCase
{
    private const TOKEN = 'abc';

    private EditAccountRequest $sut;

    protected function setUp(): void
    {
        parent::setUp();

        $this->sut = new EditAccountRequest(
            new AccessToken(self::TOKEN),
        );
    }

    /** @test */
    public function it_can_have_short_name_specified(): void
    {
        $sut = $this->sut->withShortName('short');

        $this->assertNotSame($this->sut, $sut);
        $this->assertEquals(
            [
                'access_token' => self::TOKEN,
                'short_name' => 'short',
            ],
            $sut->getJson(),
        );
    }

    /**
     * @test
     *
     * @dataProvider invalidShortNamesDataProvider
     */
    public function it_does_not_accept_invalid_short_names(string $shortName): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->sut->withShortName($shortName);
    }

    /** @test */
    public function it_can_have_author_name_specified(): void
    {
        $sut = $this->sut->withAuthorName('author');

        $this->assertNotSame($this->sut, $sut);
        $this->assertEquals(
            [
                'access_token' => self::TOKEN,
                'author_name' => 'author',
            ],
            $sut->getJson(),
        );
    }

    /**
     * @test
     *
     * @dataProvider invalidAuthorNamesDataProvider
     */
    public function it_does_not_accept_invalid_author_names(string $authorName): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->sut->withAuthorName($authorName);
    }

    /** @test */
    public function it_can_have_author_url_specified(): void
    {
        $sut = $this->sut->withAuthorUrl('url');

        $this->assertNotSame($this->sut, $sut);
        $this->assertEquals(
            [
                'access_token' => self::TOKEN,
                'author_url' => 'url',
            ],
            $sut->getJson(),
        );
    }

    /**
     * @test
     *
     * @dataProvider invalidAuthorUrlsDataProvider
     */
    public function it_does_not_accept_invalid_author_urls(string $authorName): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->sut->withAuthorUrl($authorName);
    }

    /** @test */
    public function it_can_be_empty(): void
    {
        $sut = new EditAccountRequest(
            new AccessToken('abc')
        );

        $this->assertTrue($sut->isEmpty());
    }

    /**
     * @test
     *
     * @dataProvider argumentsForJsonDataProvider
     */
    public function it_provides_proper_array_for_json(string $shortName, string $authorName, string $authorUrl): void
    {
        $sut = $this->sut;

        if ($shortName !== '') {
            $sut = $sut->withShortName($shortName);
        }
        if ($authorName !== '') {
            $sut = $sut->withAuthorName($authorName);
        }
        if ($authorUrl !== '') {
            $sut = $sut->withAuthorUrl($authorUrl);
        }

        $this->assertEquals(
            ['access_token' => self::TOKEN]
            + array_filter(
                [
                    'short_name' => $shortName,
                    'author_name' => $authorName,
                    'author_url' => $authorUrl,
                ]
            ),
            $sut->getJson(),
        );
    }

    public function invalidShortNamesDataProvider(): iterable
    {
        yield 'empty short name' => [''];
        yield 'too long short name' => [$this->getRandomString(33)];
    }

    public function invalidAuthorNamesDataProvider(): iterable
    {
        yield 'empty short name' => [''];
        yield 'too long short name' => [$this->getRandomString(129)];
    }

    public function invalidAuthorUrlsDataProvider(): iterable
    {
        yield 'empty short name' => [''];
        yield 'too long short name' => [$this->getRandomString(513)];
    }

    public function argumentsForJsonDataProvider(): iterable
    {
        yield 'only short name' => ['short', '', ''];
        yield 'only author name' => ['', 'author', ''];
        yield 'only author url' => ['', '', 'url'];
        yield 'short name and author name' => ['short', 'author', ''];
        yield 'short name and author url' => ['short', '', 'url'];
        yield 'all three' => ['short', 'author', 'url'];
    }

    private function getRandomString(int $length): string
    {
        return str_repeat('a', $length);
    }
}
