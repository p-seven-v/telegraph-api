<?php

declare(strict_types=1);

namespace Tests\Unit\Domain;

use Assert\InvalidArgumentException;
use P7v\TelegraphApi\Domain\AccessToken;
use PHPUnit\Framework\TestCase;

/**
 * @covers \P7v\TelegraphApi\Domain\AccessToken
 */
class AccessTokenTest extends TestCase
{
    /** @test */
    public function it_can_be_created(): void
    {
        $this->assertInstanceOf(
            AccessToken::class,
            new AccessToken('token')
        );
    }

    /** @test */
    public function it_throws_exception_for_empty_argument(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new AccessToken('');
    }

    /** @test */
    public function it_provides_value_properly(): void
    {
        $string = 'token';
        $sut = new AccessToken($string);

        $this->assertSame($string, $sut->getValue());
    }
}
