<?php

declare(strict_types=1);

namespace P7v\TelegraphApi\Domain;

use Assert\Assertion;
use Assert\AssertionFailedException;

final class AccessToken
{
    /** @var non-empty-string */
    private string $token;

    /**
     * @throws AssertionFailedException
     */
    public function __construct(string $token)
    {
        Assertion::notEmpty($token);

        $this->token = $token;
    }

    /**
     * @return non-empty-string
     */
    public function getValue(): string
    {
        return $this->token;
    }
}
