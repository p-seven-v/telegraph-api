<?php

declare(strict_types=1);

namespace P7v\TelegraphApi\Mapper;

use P7v\TelegraphApi\Domain\Requests\CreateAccountRequest;

class RequestMapper
{
    /**
     * @return array{short_name: non-empty-string, author_name?: string, author_url?: string}
     */
    public function mapCreateAccountRequest(CreateAccountRequest $request): array
    {
        return array_filter([
            'short_name' => $request->getShortName(),
            'author_name' => $request->getAuthorName(),
            'author_url' => $request->getAuthorUrl(),
        ]);
    }
}
