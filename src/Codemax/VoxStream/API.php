<?php

namespace Codemax\VoxStream;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;

class API implements VoxInterface
{
    use VoxFunctions;

    private $host;
    private $chave_api;
    public $response = array();
    public $error = array();
    public $success = array();

    /**
     * API constructor.
     * @param $host
     */
    public function __construct($options = array())
    {
        if(!$this->checkOptions($options))
        {
            $this->setHost($options['host']);
            $this->setChaveAPI($options['chave_api']);
        }
    }

    public function getHost()
    {
        return $this->host;
    }

    public function reportError($param, $message)
    {
        $array = [
            'param' => $param,
            'verbose' => $message,
        ];

        array_push($this->error, $array);
    }

    public function getChaveAPI()
    {
        return $this->chave_api;
    }

    public function responseJSON()
    {
        if(count($this->error) != 0)
        {
            $response = [
                'status' => 'error',
                'errors' => $this->error,
            ];

            echo \GuzzleHttp\json_encode($response);
        }else{
            $response = [
                'status' => 'success',
                'response' => $this->success
            ];

            echo \GuzzleHttp\json_encode($response);
        }
    }

    private function checkOptions($options)
    {
        if (empty($options['host'])) {
            $this->reportError('host', 'Servidor não configurado.');
        }
        if (empty($options['chave_api'])) {
            $this->reportError('chave_api', 'Chave API não configurada.');
        }
    }

    public function setHost($host)
    {
        $this->host = $host;
        return $this;
    }

    public function setChaveAPI($chave)
    {
        $this->chave_api = $chave;
        return $this;
    }

    protected function runQuery($action, $arguments, $throw=false)
    {
        $host = $this->getHost();
        $chave = $this->getChaveAPI();

        $client = new Client(['base_uri' => $host.'/admin/api/'.$chave.'/']);

        try{
            $response = $client->request('GET', $action.'/'.$arguments);

            $return = (string) $response->getBody();
            list ($status, $dados, $msg) = explode ('|', $return);

            if ($status == 1){
                $success = [
                    'status' => $status,
                    'data' => $dados,
                    'verbose' => $msg
                ];

                array_push($this->success, $success);
            }else{
                $this->reportError('desconhecido', 'Permissão negada / Revenda não existe.');
            }

            $this->responseJSON();
        }
        catch(RequestException $e)
        {
            $erro = $e->getHandlerContext();
            $this->reportError('host', 'Não foi possível se conectar ao Servidor: '.$this->getHost());
            $this->responseJSON();
        }
    }
}