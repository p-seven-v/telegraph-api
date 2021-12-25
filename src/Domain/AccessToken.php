<?php

declare(strict_types=1);

namespace P7v\TelegraphApi\Domain;

use Assert\Assert;
use Assert\InvalidArgumentException;

final class AccessToken
{
    /** @var non-empty-string */
    private string $token;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(string $token)
    {
        Assert::that($token)->notEmpty();

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
