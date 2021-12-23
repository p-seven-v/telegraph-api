<?php

declare(strict_types=1);

namespace P7v\TelegraphApi;

use Assert\Assert;
use Assert\AssertionFailedException;

class DomainValidator
{
    /**
     * @throws AssertionFailedException
     */
    public function validateShortName(string $name): void
    {
        Assert::that($name)->notEmpty()->maxLength(32);
    }

    /**
     * @throws AssertionFailedException
     */
    public function validateAuthorName(?string $name): void
    {
       Assert::thatNullOr($name)->notEmpty()->maxLength(128);
    }
}
