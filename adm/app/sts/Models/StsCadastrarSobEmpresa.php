<?php

namespace App\sts\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class StsCadastrarSobEmpresa
{

    private $Resultado;
    private $Dados;
    private $DadosId;
    private $Foto;
    private $UltimoSobEmpresa;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function verSobEmpresa($DadosId)
    {
        $this->DadosId = (int) $DadosId;
        $verSobEmpresa = new \App\adms\Models\helper\AdmsRead();
        $verSobEmpresa->fullRead("SELECT * FROM sts_sobs_emps WHERE id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verSobEmpresa->getResultado();
        return $this->Resultado;
    }

    public function cadSobEmpresa(array $Dados)
    {
        $this->Dados = $Dados;
        $this->Foto = $this->Dados['imagem_nova'];
        unset($this->Dados['imagem_nova']);

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->inserirSobEmpresa();
        } else {
            $this->Resultado = false;
        }
    }

    private function inserirSobEmpresa()
    {   
        $this->Dados['created'] = date("Y-m-d H:i:s");
        $slugImg = new \App\adms\Models\helper\AdmsSlug();
        $this->Dados['imagem'] = $slugImg->nomeSlug($this->Foto['name']);
        $this->verUltimoSobEmpresa();
        $this->Dados['ordem'] = $this->UltimoSobEmpresa[0]['ordem'] + 1;

        $cadSobEmpresa = new \App\adms\Models\helper\AdmsCreate;
        $cadSobEmpresa->exeCreate("sts_sobs_emps", $this->Dados);
        if ($cadSobEmpresa->getResultado()) {
            if (empty($this->Foto['name'])) {
                $_SESSION['msg'] = "<div class='alert alert-success'>Sobre empresa cadastrado com sucesso!</div>";
                $this->Resultado = true;
            } else {
                $this->Dados['id'] = $cadSobEmpresa->getResultado();
                $this->valFoto();
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Sobre empresa não foi cadastrado!</div>";
            $this->Resultado = false;
        }
    }
    
    private function verUltimoSobEmpresa()
    {
        $verSobEmpresa = new \App\adms\Models\helper\AdmsRead();
        $verSobEmpresa->fullRead("SELECT ordem FROM sts_sobs_emps ORDER BY ordem DESC LIMIT :limit", "limit=1");
        $this->UltimoSobEmpresa = $verSobEmpresa->getResultado();
    }

    private function valFoto()
    {
        $uploadImg = new \App\adms\Models\helper\AdmsUploadImgRed();
        $uploadImg->uploadImagem($this->Foto, '../assets/imagens/sob_emp/' . $this->Dados['id'] . '/', $this->Dados['imagem'], 500, 400);
        if ($uploadImg->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Sobre empresa cadastrado com sucesso. Upload da imagem realizado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-info'>Erro: O sobre empresa foi cadastrado. Erro ao realizar o upload da imagem!</div>";
            $this->Resultado = false;
        }
    }

    public function listarCadastrar()
    {
        $listar = new \App\adms\Models\helper\AdmsRead();
        $listar->fullRead("SELECT id id_sit, nome nome_sit FROM adms_sits ORDER BY nome ASC");
        $registro['sit'] = $listar->getResultado();

        $this->Resultado = ['sit' => $registro['sit']];

        return $this->Resultado;
    }

}
