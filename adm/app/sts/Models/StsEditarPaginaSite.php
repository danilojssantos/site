<?php

namespace App\sts\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class StsEditarPaginaSite
{

    private $Resultado;
    private $Dados;
    private $DadosId;
    private $Foto;
    private $ImgAntiga;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function verPaginaSite($DadosId)
    {
        $this->DadosId = (int) $DadosId;
        $verPaginaSite = new \App\adms\Models\helper\AdmsRead();
        $verPaginaSite->fullRead("SELECT * FROM sts_paginas 
                WHERE id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verPaginaSite->getResultado();
        return $this->Resultado;
    }

    public function altPaginaSite(array $Dados)
    {
        $this->Dados = $Dados;
        //var_dump($this->Dados);
        $this->Foto = $this->Dados['imagem_nova'];
        $this->ImgAntiga = $this->Dados['imagem_antiga'];
        unset($this->Dados['imagem_nova'], $this->Dados['imagem_antiga']);

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->valPaginaSite();
        } else {
            $this->Resultado = false;
        }
    }

    private function valPaginaSite()
    {
        if (empty($this->Foto['name'])) {
            $this->updateEditPaginaSite();
        } else {
            $slugImg = new \App\adms\Models\helper\AdmsSlug();
            $this->Dados['imagem'] = $slugImg->nomeSlug($this->Foto['name']);

            $uploadImg = new \App\adms\Models\helper\AdmsUploadImgRed();
            $uploadImg->uploadImagem($this->Foto, '../assets/imagens/pagina/' . $this->Dados['id'] . '/', $this->Dados['imagem'], 1200, 627);
            if ($uploadImg->getResultado()) {
                $apagarImg = new \App\adms\Models\helper\AdmsApagarImg();
                $apagarImg->apagarImg('../assets/imagens/pagina/' . $this->Dados['id'] . '/' . $this->ImgAntiga);
                $this->updateEditPaginaSite();
            } else {
                $this->Resultado = false;
            }
        }
    }

    private function updateEditPaginaSite()
    {
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAltPaginaSite = new \App\adms\Models\helper\AdmsUpdate();
        $upAltPaginaSite->exeUpdate("sts_paginas", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);
        if ($upAltPaginaSite->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>´Página do site atualizado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Página do site não foi atualizado!</div>";
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
