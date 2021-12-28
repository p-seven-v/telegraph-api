<?php

declare(strict_types=1);

namespace P7v\TelegraphApi;

use GuzzleHttp\Client as GuzzleClient;
use JsonException;
use P7v\TelegraphApi\Domain\Account;
use P7v\TelegraphApi\Domain\Requests\CreateAccountRequest;
use P7v\TelegraphApi\Domain\Requests\EditAccountRequest;
use P7v\TelegraphApi\Domain\Requests\GetAccountInfoRequest;
use P7v\TelegraphApi\Domain\Requests\RevokeAccessTokenRequest;
use P7v\TelegraphApi\Exceptions\TelegraphApiException;
use Psr\Http\Message\ResponseInterface;

final class Client
{
    private string $url = 'https://api.telegra.ph/';

    private GuzzleClient $httpClient;

    public function __construct()
    {
        $this->httpClient = new GuzzleClient(['base_uri' => $this->url]);
    }

    public function createAccount(CreateAccountRequest $request): Account
    {
        $response = $this->httpClient->post('createAccount', [
            'json' => $request->getJson(),
        ]);

        return Account::fromApiResponse($this->handleResponse($response));
    }

    public function getAccountInfo(GetAccountInfoRequest $request): Account
    {
        $response = $this->httpClient->post('/getAccountInfo', [
            'json' => $request->getJson(),
        ]);

        return Account::fromApiResponse($this->handleResponse($response));
    }

    public function editAccountInfo(EditAccountRequest $editAccountRequest): Account
    {
        $response = $this->httpClient->post('/editAccountInfo', [
            'json' => $editAccountRequest->getJson(),
        ]);

        return Account::fromApiResponse($this->handleResponse($response));
    }

    public function revokeAccessToken(RevokeAccessTokenRequest $request): Account
    {
        $response = $this->httpClient->post('/revokeAccessToken', [
            'json' => $request->getJson(),
        ]);

        return Account::fromApiResponse($this->handleResponse($response));
    }

    /**
     * @param ResponseInterface $response
     *
     * @return array<string, mixed>
     *
     * @throws TelegraphApiException
     */
    protected function handleResponse(ResponseInterface $response): array
    {
        try {
            $response = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $exception) {
            throw new TelegraphApiException('Invalid response from Telegra.ph API', 0, $exception);
        }

        if (!$response['ok']) {
            throw new TelegraphApiException($response['error']);
        }

        if (!is_array($response['result'])) {
            throw new TelegraphApiException('Result in response is of unexpected format');
        }

        return $response['result'];
    }
}
