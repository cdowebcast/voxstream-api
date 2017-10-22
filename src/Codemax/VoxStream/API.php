<?php

namespace Codemax\VoxStream;

use GuzzleHttp\Client;

class API
{
    use VoxFunctions;

    private $host;
    private $chave_api;

    /**
     * API constructor.
     * @param $host
     */
    public function __construct($options = array())
    {
        if(!empty($options))
        {
            $this->host = $options['host'];
            $this->chave_api = $options['chave_api'];
        }
    }

    public function getHost()
    {
        return $this->host;
    }

    public function getChaveAPI()
    {
        return $this->chave_api;
    }

    public function setHost($host)
    {
        $this->host = $host;
    }

    public function setChaveAPI($chave)
    {
        $this->chave_api = $chave;
    }

    protected function runQuery($action, $arguments, $throw=false)
    {
        $host = $this->getHost();
        $client = new Client(['base_uri' => $host]);
        try{
            $response = $client->post('/json-api/' . $action, [
                'headers' => $this->createHeader(),
                // 'body'    => $arguments[0],
                'verify' => false,
                'query' => $arguments,
                'timeout' => $this->getTimeout(),
                'connect_timeout' => $this->getConnectionTimeout()
            ]);
            return (string) $response->getBody();
        }
        catch(\GuzzleHttp\Exception\ClientException $e)
        {
            if ($throw) {
                throw $e;
            }
            return $e->getMessage();
        }
    }
}