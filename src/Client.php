<?php

namespace P7v\TelegraphApi;

use P7v\TelegraphApi\Entities\Page;
use GuzzleHttp\Client as GuzzleClient;
use Psr\Http\Message\ResponseInterface;
use P7v\TelegraphApi\Entities\Account;
use P7v\TelegraphApi\Entities\PageList;
use P7v\TelegraphApi\Entities\PageViews;
use P7v\TelegraphApi\Exceptions\TelegraphApiException;

class Client
{
    private string $url = 'https://api.telegra.ph/';

    private GuzzleClient $http;

    public function __construct()
    {
        $this->http = new GuzzleClient(['base_uri' => $this->url]);
    }

    public function createAccount(string $shortName, string $authorName = '', string $authorUrl = '')
    {
        $response = $this->http->post('/createAccount', [
            'json' => [
                'short_name' => $shortName,
                'author_name' => $authorName,
                'author_url' => $authorUrl
            ]
        ]);

        return new Account($this->handleResponse($response));
    }

    public function editAccountInfo($account, $shortName = '', $authorName = '', $authorUrl = '')
    {
        $response = $this->http->post('/editAccountInfo', [
            'json' => [
                'access_token' => $this->getAccessToken($account),
                'short_name' => $shortName,
                'author_name' => $authorName,
                'author_url' => $authorUrl
            ]
        ]);

        return new Account($this->handleResponse($response));
    }

    public function getAccountInfo($account, $fields = ['short_name', 'author_name', 'author_url'])
    {
        $availableFields = ['short_name', 'author_name', 'author_url', 'auth_url', 'page_count'];

        foreach ($fields as $field) {
            if (!in_array($field, $availableFields)) {
                throw new \Exception();
            }
        }

        $response = $this->http->post('/getAccountInfo', [
            'json' => [
                'access_token' => $this->getAccessToken($account),
                'fields' => $fields
            ]
        ]);

        return new Account($this->handleResponse($response));
    }

    public function revokeAccessToken($account)
    {
        $response = $this->http->post('/revokeAccessToken', [
            'json' => [
                'access_token' => $this->getAccessToken($account)
            ]
        ]);

        return new Account($this->handleResponse($response));
    }

    public function createPage($account, $title, $content, $authorName = '', $authorUrl = '', $returnContent = false)
    {
        $response = $this->http->post('/createPage', [
            'json' => [
                'access_token' => $this->getAccessToken($account),
                'title' => $title,
                'content' => $content,
                'author_name' => $authorName,
                'author_url' => $authorUrl,
                'return_content' => $returnContent
            ]
        ]);

        return new Page($this->handleResponse($response));
    }

    public function editPage($account, $path, $title, $content, $authorName = null, $authorUrl = null, $returnContent = false)
    {
        $json = array_filter([
            'access_token' => $this->getAccessToken($account),
            'path' => $path,
            'title' => $title,
            'content' => $content,
            'author_name' => $authorName,
            'author_url' => $authorUrl,
            'return_content' => $returnContent
        ]);

        $response = $this->http->post('/editPage', [
            'json' => $json
        ]);

        return new Page($this->handleResponse($response));
    }

    public function getPage($path, $returnContent = false)
    {
        $response = $this->http->post('/getPage', [
            'json' => [
                'path' => $path,
                'return_content' => $returnContent
            ]
        ]);

        return new Page($this->handleResponse($response));
    }

    public function getPageList($account, $offset = 0, $limit = 50)
    {
        $response = $this->http->post('/getPageList', [
            'json' => [
                'access_token' => $this->getAccessToken($account),
                'offset' => $offset,
                'limit' => $limit
            ]
        ]);

        return new PageList($this->handleResponse($response));
    }

    public function getViews($path, $year = null, $month = null, $day = null, $hour = null)
    {
        $json = array_filter(compact('path', 'year', 'month', 'day', 'hour'));

        $response = $this->http->post('/getViews', [
            'json' => $json
        ]);

        return new PageViews($this->handleResponse($response));
    }

    /**
     * @param  \P7v\TelegraphApi\Entities\Account|string  $account
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
     * @param  \Psr\Http\Message\ResponseInterface  $response
     * @return  array  mixed
     */
    protected function handleResponse(ResponseInterface $response)
    {
        $response = json_decode($response->getBody()->getContents(), true);

        if (!$response['ok']) {
            throw new TelegraphApiException($response['error']);
        }

        return $response['result'];
    }
}
