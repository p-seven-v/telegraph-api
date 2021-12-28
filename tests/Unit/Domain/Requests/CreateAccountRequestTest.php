<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Requests;

use Assert\InvalidArgumentException;
use P7v\TelegraphApi\Domain\Requests\CreateAccountRequest;
use PHPUnit\Framework\TestCase;

/**
 * @covers \P7v\TelegraphApi\Domain\Requests\CreateAccountRequest
 */
class CreateAccountRequestTest extends TestCase
{
    /** @test */
    public function it_can_be_created(): void
    {
        $this->assertInstanceOf(
            CreateAccountRequest::class,
            new CreateAccountRequest('aaa')
        );
        $this->assertInstanceOf(
            CreateAccountRequest::class,
            new CreateAccountRequest('aaa', 'bbb')
        );
        $this->assertInstanceOf(
            CreateAccountRequest::class,
            new CreateAccountRequest('aaa', 'bbb', 'ccc')
        );
        $this->assertInstanceOf(
            CreateAccountRequest::class,
            new CreateAccountRequest('aaa', '', 'ccc')
        );
        $this->assertInstanceOf(
            CreateAccountRequest::class,
            new CreateAccountRequest('aaa', 'bbb', '')
        );
        $this->assertInstanceOf(
            CreateAccountRequest::class,
            new CreateAccountRequest('aaa', '', '')
        );
    }

    /**
     * @test
     *
     * @dataProvider invalidArgumentsDataProvider
     */
    public function it_is_not_created_when_arguments_are_invalid(string $shortName, string $authorName, string $authorUrl): void
    {
        $this->expectException(InvalidArgumentException::class);

        new CreateAccountRequest($shortName, $authorName, $authorUrl);
    }

    /**
     * @test
     *
     * @dataProvider argumentsForJsonDataProvider
     */
    public function it_provides_proper_array_for_json(string $shortName, string $authorName, string $authorUrl): void
    {
        $sut = new CreateAccountRequest($shortName, $authorName, $authorUrl);

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

    public function invalidArgumentsDataProvider(): iterable
    {
        yield 'empty short name' => ['', '', ''];
        yield 'short name is too long' => [$this->getRandomString(33), '', ''];
        yield 'author name is too long' => ['a', $this->getRandomString(129), ''];
        yield 'author url is too long' => ['a', 'b', $this->getRandomString(513)];
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
