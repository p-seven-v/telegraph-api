<?php

declare(strict_types=1);

namespace P7v\TelegraphApi\Domain\Requests;

interface RequestInterface
{
    /**
     * @return array<string, mixed>
     *
     * @internal
     */
    public function getJson(): array;
}
