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

            if (empty($args['aacplus']) || !isset($args['aacplus'])) {
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
                'aacplus' => @$args['aacplus'],
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
     * Criar uma Nova Conta de Revenda
     *
     * @param $args
     */
    public function createReseller($args)
    {
        try{
            if (empty($args['streamings']) || !isset($args['streamings'])) {
                $this->reportError('stramings', 'Limite de Streamings não definido.');
            }

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

            if (empty($args['aacplus']) || !isset($args['aacplus'])) {
                $this->reportError('aacplus', 'ACC+ RTMP não definido.');
            }

            if (empty($args['subrevendas']) || !isset($args['subrevendas'])) {
                $this->reportError('subrevendas', 'Quantidade de Sub-Revendas não definido.');
            }

            if (empty($args['email']) || !isset($args['email'])) {
                $this->reportError('email', 'E-mail principal não definido.');
            }

            $array = array(
                'streamings' => @$args['streamings'],
                'ouvintes' => @$args['ouvintes'],
                'bitrate' => @$args['bitrate'],
                'espaco' => @$args['disco'],
                'senha' => @$args['senha'],
                'aacplus' => @$args['aacplus'],
                'idioma' => 'pt-br',
                'subrevendas' => @$args['subrevendas'],
                'email_subrevenda' => @$args['email'],
            );

            $params = implode('/', $array);
            $this->runQuery('cadastrar_subrevenda', $params, true);

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
     * Remover uma Conta de Revenda
     *
     * @param $porta
     */
    public function removeReseller($id_revenda)
    {
        if (empty($id_revenda) || !isset($id_revenda)) {
            $this->reportError('id', 'ID Revenda é obrigatório.');
        }

        $this->runQuery('remover_subrevenda', $id_revenda);
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

    /**
     * Bloquear uma Conta de Revenda
     *
     * @param $porta
     */
    public function suspendReseller($id_revenda)
    {
        if (empty($id_revenda) || !isset($id_revenda)) {
            $this->reportError('id', 'ID Revenda é obrigatório.');
        }

        $this->runQuery('bloquear_subrevenda', $id_revenda);
    }

    /**
     * Desbloquear uma Conta
     *
     * @param $porta
     */
    public function unsuspendAccount($porta)
    {
        if (empty($porta) || !isset($porta)) {
            $this->reportError('porta', 'Porta Streaming é obrigatório.');
        }

        $this->runQuery('desbloquear', $porta);
    }

    /**
     * Desbloquear uma Conta de Revenda
     *
     * @param $porta
     */
    public function unsuspendReseller($id_revenda)
    {
        if (empty($id_revenda) || !isset($id_revenda)) {
            $this->reportError('id', 'ID Revenda é obrigatório.');
        }

        $this->runQuery('desbloquear_subrevenda', $id_revenda);
    }

    /**
     * Alterar senha de uma Conta
     *
     * @param $porta
     */
    public function editPassword($porta, $senha)
    {
        if (empty($porta) || !isset($porta)) {
            $this->reportError('porta', 'Porta Streaming é obrigatório.');
        }

        if (empty($senha) || !isset($senha)) {
            $this->reportError('senha', 'A nova senha deve ser preenchida.');
        }

        $this->runQuery('alterar_senha', $porta."/".$senha);
    }

    /**
     * Alterar senha de uma Conta de Revenda
     *
     * @param $porta
     */
    public function editPassword_reseller($id, $senha)
    {
        if (empty($id) || !isset($id)) {
            $this->reportError('id', 'ID Revenda é obrigatório.');
        }

        if (empty($senha) || !isset($senha)) {
            $this->reportError('senha', 'A nova senha deve ser preenchida.');
        }

        $this->runQuery('alterar_senha_subrevenda', $id."/".$senha);
    }
}