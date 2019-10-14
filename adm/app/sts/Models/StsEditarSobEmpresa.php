<?php

namespace App\sts\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class StsEditarSobEmpresa
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

    public function verSobEmpresa($DadosId)
    {
        $this->DadosId = (int) $DadosId;
        $verSobEmpresa = new \App\adms\Models\helper\AdmsRead();
        $verSobEmpresa->fullRead("SELECT * FROM sts_sobs_emps 
                WHERE id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verSobEmpresa->getResultado();
        return $this->Resultado;
    }

    public function altSobEmpresa(array $Dados)
    {
        $this->Dados = $Dados;
        //var_dump($this->Dados);
        $this->Foto = $this->Dados['imagem_nova'];
        $this->ImgAntiga = $this->Dados['imagem_antiga'];
        unset($this->Dados['imagem_nova'], $this->Dados['imagem_antiga']);

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->valSobEmpresa();
        } else {
            $this->Resultado = false;
        }
    }

    private function valSobEmpresa()
    {
        if (empty($this->Foto['name'])) {
            $this->updateEditSobEmpresa();
        } else {
            $slugImg = new \App\adms\Models\helper\AdmsSlug();
            $this->Dados['imagem'] = $slugImg->nomeSlug($this->Foto['name']);

            $uploadImg = new \App\adms\Models\helper\AdmsUploadImgRed();
            $uploadImg->uploadImagem($this->Foto, '../assets/imagens/sob_emp/' . $this->Dados['id'] . '/', $this->Dados['imagem'], 500, 400);
            if ($uploadImg->getResultado()) {
                $apagarImg = new \App\adms\Models\helper\AdmsApagarImg();
                $apagarImg->apagarImg('../assets/imagens/sob_emp/' . $this->Dados['id'] . '/' . $this->ImgAntiga);
                $this->updateEditSobEmpresa();
            } else {
                $this->Resultado = false;
            }
        }
    }

    private function updateEditSobEmpresa()
    {
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAltSobEmpresa = new \App\adms\Models\helper\AdmsUpdate();
        $upAltSobEmpresa->exeUpdate("sts_sobs_emps", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);
        if ($upAltSobEmpresa->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Sobre empresa atualizado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Sobre empresa não foi atualizado!</div>";
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
