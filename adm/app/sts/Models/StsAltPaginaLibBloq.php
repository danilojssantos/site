<?php

namespace App\sts\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class StsAltPaginaLibBloq
{

    private $DadosId;
    private $Resultado;
    private $Dados;
    private $DadosPaginaSite;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function altPaginaLibBloq($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        $this->verPaginaSite();
        if ($this->DadosPaginaSite) {
            $this->altPaginaSite();
        }else{
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Não foi alterado a situação da página no menu!</div>";
            $this->Resultado = false;
        }
    }

    private function verPaginaSite()
    {
        $verPaginaSite = new \App\adms\Models\helper\AdmsRead();
        $verPaginaSite->fullRead("SELECT id, lib_bloq 
                FROM sts_paginas
                WHERE id =:id", "id={$this->DadosId}");        
        $this->DadosPaginaSite = $verPaginaSite->getResultado();
    }

    private function altPaginaSite()
    {
        if ($this->DadosPaginaSite[0]['lib_bloq'] == 1) {
            $this->Dados['lib_bloq'] = 2;
        } else {
            $this->Dados['lib_bloq'] = 1;
        }
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upPaginaSite = new \App\adms\Models\helper\AdmsUpdate();
        $upPaginaSite->exeUpdate("sts_paginas", $this->Dados, "WHERE id =:id", "id={$this->DadosId}");

        if ($upPaginaSite->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Alterado a situação da página no menu!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Não foi alterado a situação da página no menu!</div>";
            $this->Resultado = false;
        }
    }

}
