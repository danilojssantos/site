<?php

namespace App\sts\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class StsCadastrarPaginaSite
{

    private $Resultado;
    private $Dados;
    private $Foto;
    private $UltimoPaginaSite;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function cadPaginaSite(array $Dados)
    {
        $this->Dados = $Dados;
        $this->Foto = $this->Dados['imagem_nova'];
        unset($this->Dados['imagem_nova']);

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->inserirPaginaSite();
        } else {
            $this->Resultado = false;
        }
    }

    private function inserirPaginaSite()
    {   
        $this->Dados['created'] = date("Y-m-d H:i:s");
        $slugImg = new \App\adms\Models\helper\AdmsSlug();
        $this->Dados['imagem'] = $slugImg->nomeSlug($this->Foto['name']);
        $this->verUltimoPaginaSite();
        $this->Dados['ordem'] = $this->UltimoPaginaSite[0]['ordem'] + 1;

        $cadPaginaSite = new \App\adms\Models\helper\AdmsCreate;
        $cadPaginaSite->exeCreate("sts_paginas", $this->Dados);
        if ($cadPaginaSite->getResultado()) {
            if (empty($this->Foto['name'])) {
                $_SESSION['msg'] = "<div class='alert alert-success'>Página do site cadastrado com sucesso!</div>";
                $this->Resultado = true;
            } else {
                $this->Dados['id'] = $cadPaginaSite->getResultado();
                $this->valFoto();
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Página do site não foi cadastrado!</div>";
            $this->Resultado = false;
        }
    }
    
    private function verUltimoPaginaSite()
    {
        $verPaginaSite = new \App\adms\Models\helper\AdmsRead();
        $verPaginaSite->fullRead("SELECT ordem FROM sts_paginas ORDER BY ordem DESC LIMIT :limit", "limit=1");
        $this->UltimoPaginaSite = $verPaginaSite->getResultado();
    }

    private function valFoto()
    {
        $uploadImg = new \App\adms\Models\helper\AdmsUploadImgRed();
        $uploadImg->uploadImagem($this->Foto, '../assets/imagens/pagina/' . $this->Dados['id'] . '/', $this->Dados['imagem'], 1200, 627);
        if ($uploadImg->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Página do site cadastrado com sucesso. Upload da imagem realizado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-info'>Erro: Página do site não foi cadastrado. Erro ao realizar o upload da imagem!</div>";
            $this->Resultado = false;
        }
    }

    public function listarCadastrar()
    {
        $listar = new \App\adms\Models\helper\AdmsRead();
        $listar->fullRead("SELECT id id_rob, nome nome_rob, tipo tipo_rob FROM sts_robots ORDER BY nome ASC");
        $registro['rob'] = $listar->getResultado();

        $listar->fullRead("SELECT id id_tpg, tipo tipo_tpg, nome nome_tpg FROM sts_tps_pgs ORDER BY nome ASC");
        $registro['tpg'] = $listar->getResultado();

        $listar->fullRead("SELECT id id_sitpg, nome nome_sitpg FROM sts_situacaos_pgs ORDER BY nome ASC");
        $registro['sitpg'] = $listar->getResultado();

        $this->Resultado = ['rob' => $registro['rob'], 'tpg' => $registro['tpg'], 'sitpg' => $registro['sitpg']];

        return $this->Resultado;
    }

}
