<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Requests;

use InvalidArgumentException;
use P7v\TelegraphApi\Domain\Requests\CreateAccountRequest;
use PHPUnit\Framework\TestCase;

/**
 * @covers \P7v\TelegraphApi\Domain\Requests\CreateAccountRequest
 */
class CreateAccountRequestTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider invalidShortNamesDataProvider
     */
    public function it_does_not_accept_invalid_short_names(string $shortName): void
    {
        $this->expectException(InvalidArgumentException::class);

        new CreateAccountRequest($shortName);
    }

    /** @test */
    public function it_can_have_author_name_specified(): void
    {
        $initialSut = new CreateAccountRequest('short');
        $sut = $initialSut->withAuthorName('author');

        $this->assertNotSame($initialSut, $sut);
        $this->assertEquals(
            [
                'short_name' => 'short',
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

        (new CreateAccountRequest('short'))->withAuthorName($authorName);
    }

    /** @test */
    public function it_can_have_author_url_specified(): void
    {
        $initialSut = new CreateAccountRequest('short');
        $sut = $initialSut->withAuthorUrl('url');

        $this->assertNotSame($initialSut, $sut);
        $this->assertEquals(
            [
                'short_name' => 'short',
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

        (new CreateAccountRequest('short'))->withAuthorUrl($authorName);
    }

    /**
     * @test
     *
     * @dataProvider argumentsForJsonDataProvider
     */
    public function it_provides_proper_array_for_json(string $shortName, string $authorName, string $authorUrl): void
    {
        $sut = new CreateAccountRequest($shortName);

        if ($authorName !== '') {
            $sut = $sut->withAuthorName($authorName);
        }
        if ($authorUrl !== '') {
            $sut = $sut->withAuthorUrl($authorUrl);
        }

        $this->assertEquals(
            array_filter(
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
        yield 'short name and author name' => ['short', 'author', ''];
        yield 'short name and author url' => ['short', '', 'url'];
        yield 'all three' => ['short', 'author', 'url'];
    }

    private function getRandomString(int $length): string
    {
        return str_repeat('a', $length);
    }
}
