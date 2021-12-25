<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Requests;

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
}
