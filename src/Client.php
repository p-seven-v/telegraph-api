<?php

declare(strict_types=1);

namespace P7v\TelegraphApi;

use GuzzleHttp\Client as GuzzleClient;
use JsonException;
use P7v\TelegraphApi\Domain\Requests\CreateAccountRequest;
use P7v\TelegraphApi\Entities\Account;
use P7v\TelegraphApi\Entities\Page;
use P7v\TelegraphApi\Entities\PageList;
use P7v\TelegraphApi\Entities\PageViews;
use P7v\TelegraphApi\Exceptions\TelegraphApiException;
use P7v\TelegraphApi\Mapper\RequestMapper;
use Psr\Http\Message\ResponseInterface;

final class Client
{
    private string $url = 'https://api.telegra.ph/';

    private GuzzleClient $httpClient;

    private RequestMapper $requestMapper;

    public function __construct()
    {
        $this->httpClient = new GuzzleClient(['base_uri' => $this->url]);
        $this->requestMapper = new RequestMapper();
    }

    public function createAccount(CreateAccountRequest $request): Account
    {
        $response = $this->httpClient->post('createAccount', [
            'json' => $this->requestMapper->mapCreateAccountRequest($request),
        ]);

        return Account::fromApiResponse($this->handleResponse($response));
    }

    public function editAccountInfo($account, $shortName = '', $authorName = '', $authorUrl = '')
    {
        $response = $this->httpClient->post('/editAccountInfo', [
            'json' => [
                'access_token' => $this->getAccessToken($account),
                'short_name' => $shortName,
                'author_name' => $authorName,
                'author_url' => $authorUrl,
            ],
        ]);

        return Account::fromApiResponse($this->handleResponse($response));
    }

    public function getAccountInfo($account, $fields = ['short_name', 'author_name', 'author_url'])
    {
        $availableFields = ['short_name', 'author_name', 'author_url', 'auth_url', 'page_count'];

        foreach ($fields as $field) {
            if (!in_array($field, $availableFields)) {
                throw new \Exception();
            }
        }

        $response = $this->httpClient->post('/getAccountInfo', [
            'json' => [
                'access_token' => $this->getAccessToken($account),
                'fields' => $fields,
            ],
        ]);

        return new Account($this->handleResponse($response));
    }

    public function revokeAccessToken($account)
    {
        $response = $this->httpClient->post('/revokeAccessToken', [
            'json' => [
                'access_token' => $this->getAccessToken($account),
            ],
        ]);

        return new Account($this->handleResponse($response));
    }

    public function createPage($account, $title, $content, $authorName = '', $authorUrl = '', $returnContent = false)
    {
        $response = $this->httpClient->post('/createPage', [
            'json' => [
                'access_token' => $this->getAccessToken($account),
                'title' => $title,
                'content' => $content,
                'author_name' => $authorName,
                'author_url' => $authorUrl,
                'return_content' => $returnContent,
            ],
        ]);

        return new Page($this->handleResponse($response));
    }

    public function editPage(
        $account,
        $path,
        $title,
        $content,
        $authorName = null,
        $authorUrl = null,
        $returnContent = false
    ) {
        $json = array_filter([
                                 'access_token' => $this->getAccessToken($account),
                                 'path' => $path,
                                 'title' => $title,
                                 'content' => $content,
                                 'author_name' => $authorName,
                                 'author_url' => $authorUrl,
                                 'return_content' => $returnContent,
                             ]);

        $response = $this->httpClient->post('/editPage', [
            'json' => $json,
        ]);

        return new Page($this->handleResponse($response));
    }

    public function getPage($path, $returnContent = false)
    {
        $response = $this->httpClient->post('/getPage', [
            'json' => [
                'path' => $path,
                'return_content' => $returnContent,
            ],
        ]);

        return new Page($this->handleResponse($response));
    }

    public function getPageList($account, $offset = 0, $limit = 50)
    {
        $response = $this->httpClient->post('/getPageList', [
            'json' => [
                'access_token' => $this->getAccessToken($account),
                'offset' => $offset,
                'limit' => $limit,
            ],
        ]);

        return new PageList($this->handleResponse($response));
    }

    public function getViews($path, $year = null, $month = null, $day = null, $hour = null)
    {
        $json = array_filter(compact('path', 'year', 'month', 'day', 'hour'));

        $response = $this->httpClient->post('/getViews', [
            'json' => $json,
        ]);

        return new PageViews($this->handleResponse($response));
    }

    /**
     * @param \P7v\TelegraphApi\Entities\Account|string $account
     * @return  mixed
     */
    protected function getAccessToken($account)
    {
        if ($account instanceof Account) {
            return $account['access_token'];
        }

        return $account;
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
