<?php

namespace Codemax\VoxStream;

trait VoxFunctions
{
    /**
     * Criar uma Nova Conta
     *
     * @param $args
     */
    public function createAccount($args)
    {
        try{
            if (empty($args['ouvintes']) || !isset($args['ouvintes'])) {
                $this->reportError('ouvintes', 'Quantidade de Ouvintes não definido.');
            }

            if (empty($args['bitrate']) || !isset($args['bitrate'])) {
                $this->reportError('bitrate', 'Qualidade Bitrate não definido.');
            }

            if (empty($args['disco']) || !isset($args['disco'])) {
                $this->reportError('disco', 'Espaço em Disco não definido.');
            }

            if (empty($args['senha']) || !isset($args['senha'])) {
                $this->reportError('senha', 'Senha não definida.');
            }

            if (empty($args['accplus']) || !isset($args['accplus'])) {
                $this->reportError('accplus', 'ACC+ RTMP não definido.');
            }

            if (empty($args['android']) || !isset($args['android'])) {
                $this->reportError('android', 'Aplicativo Android não definido.');
            }

            $array = array(
                'ouvintes' => @$args['ouvintes'],
                'bitrate' => @$args['bitrate'],
                'disco' => @$args['disco'],
                'senha' => @$args['senha'],
                'aacplus' => @$args['accplus'],
                'lingua' => 'pt-br',
                'android' => @$args['android'],
                'encoder' => 'sim',
                'enc_aacplus' => 'sim',
            );

            $params = implode('/', $array);
            $this->runQuery('cadastrar', $params, true);

        }catch (\Exception $e){
            echo $e->getMessage();
        }
    }

    /**
     * Remover uma Conta
     *
     * @param $porta
     */
    public function removeAccount($porta)
    {
        if (empty($porta) || !isset($porta)) {
            $this->reportError('porta', 'Porta Streaming é obrigatório.');
        }

        $this->runQuery('remover', $porta);
    }

    /**
     * Suspender uma Conta
     *
     * @param $porta
     */
    public function suspendAccount($porta)
    {
        if (empty($porta) || !isset($porta)) {
            $this->reportError('porta', 'Porta Streaming é obrigatório.');
        }

        $this->runQuery('bloquear', $porta);
    }
}