<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Requests;

use P7v\TelegraphApi\Domain\AccessToken;
use P7v\TelegraphApi\Domain\Requests\GetAccountInfoRequest;
use PHPUnit\Framework\TestCase;

/**
 * @covers \P7v\TelegraphApi\Domain\Requests\GetAccountInfoRequest
 */
class GetAccountInfoRequestTest  extends TestCase
{
    /** @test */
    public function it_provides_proper_array_for_json(): void
    {
        $token = 'abc';
        $sut = new GetAccountInfoRequest(
            new AccessToken($token)
        );

        $this->assertEquals(
            [
                'access_token' => $token,
            ],
            $sut->getJson(),
        );
    }
}
