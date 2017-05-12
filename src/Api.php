<?php

namespace Zebreco;

use GuzzleHttp\Client;

class Api
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var string
     */
    protected $account;

    /**
     * @var string
     */
    protected $user;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string
     */
    protected $endpoint;

    /**
     * @param string $account
     * @param string $user
     * @param string $password
     * @param string $endpoint
     */
    public function __construct($account, $user, $password, $endpoint)
    {
        $this->account  = $account;
        $this->user     = $user;
        $this->password = $password;
        $this->endpoint = $endpoint;

        $this->client = new Client([
            'base_uri' => $this->getBaseUri()
        ]);
    }

    protected function request($type, $data)
    {
        $request = ['auth' => [$this->user, $this->password]];
        switch ($type) {
            case 'POST':
            case 'PATCH':
            case 'PUT':
                $request['json'] = [$this->endpoint . 's' => $data];
                break;
        }
        return $this->client->request($type, $this->endpoint, $request);
    }

    public function getList()
    {
        return $this->respond($this->request('GET'));
    }

    public function create($data = array())
    {
        if (!empty($data)) {
            return $this->respond($this->request('POST', $data));
        }
        return false;
    }

    public function update($data = array())
    {
        if (!empty($data)) {
            return $this->respond($this->request('PATCH', $data));
        }
        return false;
    }

    protected function respond($response)
    {
        if ($response->getStatusCode() === 200) {
            return json_decode($response->getBody(), true);
        }
        return json_decode($response->getBody(), true);
    }

    protected function getBaseUri()
    {
//        return 'https://' . $this->account . '.zebreco.com/api/v1/';
        return 'http://minlare.zebreco.localhost/api/v1/';
    }
}
