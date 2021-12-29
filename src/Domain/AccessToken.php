<?php

declare(strict_types=1);

namespace P7v\TelegraphApi\Domain;

use Webmozart\Assert\Assert;

final class AccessToken
{
    /** @var non-empty-string */
    private string $token;

    public function __construct(string $token)
    {
        Assert::notEmpty($token);

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
