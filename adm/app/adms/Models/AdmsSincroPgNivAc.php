<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AdmsSincroPgNivAc
{

    private $Resultado;
    private $ListaNivAc;
    private $DadosNivAcPg;
    private $NivAcId;
    private $PgId;
    private $ListarPg;
    private $ListarNivAcPg;
    private $ListaNivAcPgOrd;
    private $LibPub;

    /**
     * <b>Obter Resultado:</b> Retorna TRUE caso tenha sincronizado com sucesso e FALSE quando não conseguiu sincronizar
     * @return BOOL true ou false
     */
    function getResultado()
    {
        return $this->Resultado;
    }

    /**
     * <b>Sincronizar Página:</b> Sincronizar as páginas com os níveis de acesso
     * Para cada nível de acesso ter a permissão cadastrada na tabela "adms_nivacs_pgs"
     */
    public function sincroPgNivAc()
    {
        $this->listarNivAc();
        if ($this->ListaNivAc) {
            $this->listarPg();
            if ($this->ListarPg) {
                $this->lerNivAc();
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Nenhum página encontrada!</div>";
                $this->Resultado = false;
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Nenhum nível de acesso encontrado!</div>";
            $this->Resultado = false;
        }
    }

    /**
     * <b>Listar Nível de acesso:</b> Pesquisar os níves de acesso para liberar a permissão de acessar as páginas 
     */
    private function listarNivAc()
    {
        $listarNivAc = new \App\adms\Models\helper\AdmsRead();
        $listarNivAc->fullRead("SELECT id FROM adms_niveis_acessos");
        $this->ListaNivAc = $listarNivAc->getResultado();
    }

    /**
     * <b>Listar as Páginas:</b> Pesquisar as páginas para liberar a permissão para os níveis de acesso 
     */
    private function listarPg()
    {
        $listarPg = new \App\adms\Models\helper\AdmsRead();
        $listarPg->fullRead("SELECT id, lib_pub FROM adms_paginas");
        $this->ListarPg = $listarPg->getResultado();
    }

    /**
     * <b>Ler os nível de acesso:</b> Ler o array de nível de acesso para chamar o método ler as páginas
     */
    private function lerNivAc()
    {
        foreach ($this->ListaNivAc as $nivAc) {
            extract($nivAc);
            $this->NivAcId = $id;
            $this->lerPg();
        }
    }

    /**
     * <b>Ler as páginas:</b> Ler o array de páginas para verificar se o nível de acesso possui já cadastrado a permissão
     * Caso não tenha cadastrado será chamado o método "inserirPerNivAc" para inserir a permissão
     */
    private function lerPg()
    {
        foreach ($this->ListarPg as $listarPg) {
            extract($listarPg);
            $this->PgId = $id;
            $this->LibPub = $lib_pub;
            $this->pesqCadNivAcPer();
            if (!$this->ListarNivAcPg) {
                $this->inserirPerNivAc();
            }
        }
    }

    /**
     * <b>Pesquisar a permissão ao nível de acesso:</b> Pesquisar se o nível de acesso já tem a permissão cadastrada para a página
     */
    private function pesqCadNivAcPer()
    {
        $listarNivAcPg = new \App\adms\Models\helper\AdmsRead();
        $listarNivAcPg->fullRead("SELECT id FROM adms_nivacs_pgs WHERE adms_niveis_acesso_id =:adms_niveis_acesso_id AND adms_pagina_id =:adms_pagina_id", "adms_niveis_acesso_id={$this->NivAcId}&adms_pagina_id={$this->PgId}");
        $this->ListarNivAcPg = $listarNivAcPg->getResultado();
    }

    /**
     * <b>Inserir Permissão de Acesso:</b> Inserir a permissão de acesso aos niveis de acesso para a pagina pesquisada
     * Liberado a permissão de acesso quando for o nível de acesso super administrador, 
     * para outros níveis de acesso não liberar a permissão de acesso a página
     */
    private function inserirPerNivAc()
    {
        $this->DadosNivAcPg['permissao'] = ((($this->NivAcId == 1) OR ($this->LibPub == 1)) ? 1 : 2);
        $this->pesqUltimaOrdem();
        $this->DadosNivAcPg['ordem'] = $this->ListaNivAcPgOrd[0]['ordem'] + 1;
        $this->DadosNivAcPg['adms_niveis_acesso_id'] = $this->NivAcId;
        $this->DadosNivAcPg['adms_pagina_id'] = $this->PgId;
        $this->DadosNivAcPg['created'] = date("Y-m-d H:i:s");
        $cadNivAcPg = new \App\adms\Models\helper\AdmsCreate;
        $cadNivAcPg->exeCreate("adms_nivacs_pgs", $this->DadosNivAcPg);

        if ($cadNivAcPg->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Permissão cadastrado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-warning'>Erro ao inserir a permissão de acesso ao nível de acesso!</div>";
            $this->Resultado = false;
        }
    }

    /**
     * <b>Pesquisar última ordem:</b> Pesquisar o maior número da ordem na tabela "adms_nivacs_pgs" para o nível de acesso em execução
     */
    private function pesqUltimaOrdem()
    {
        $listarNivAcPgOrd = new \App\adms\Models\helper\AdmsRead();
        $listarNivAcPgOrd->fullRead("SELECT ordem, adms_niveis_acesso_id
                FROM adms_nivacs_pgs 
                WHERE adms_niveis_acesso_id =:adms_niveis_acesso_id ORDER BY ordem DESC LIMIT :limit", "adms_niveis_acesso_id={$this->NivAcId}&limit=1");
        $this->ListaNivAcPgOrd = $listarNivAcPgOrd->getResultado();
        if (!$this->ListaNivAcPgOrd) {
            $this->ListaNivAcPgOrd[0]['ordem'] = 0;
        }
    }
    
}
