<?php

namespace App\sts\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class StsEditarSobre
{

    private $Resultado;
    private $Dados;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function verSobre()
    {
        $verSobre = new \App\adms\Models\helper\AdmsRead();
        $verSobre->fullRead("SELECT * FROM sts_sobres
                WHERE id =:id LIMIT :limit", "id=1&limit=1");
        $this->Resultado = $verSobre->getResultado();
        return $this->Resultado;
    }

    public function altSobre(array $Dados)
    {
        $this->Dados = $Dados;
        
        $this->Foto = $this->Dados['imagem_nova'];
        $this->ImgAntiga = $this->Dados['imagem_antiga'];
        unset($this->Dados['imagem_nova'], $this->Dados['imagem_antiga']);

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazioComTag;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->valSobre();
        } else {
            $this->Resultado = false;
        }
    }
    
    private function valSobre()
    {
        if (empty($this->Foto['name'])) {
            $this->updateSobre();
        } else {
            $slugImg = new \App\adms\Models\helper\AdmsSlug();
            $this->Dados['imagem'] = $slugImg->nomeSlug($this->Foto['name']);

            $uploadImg = new \App\adms\Models\helper\AdmsUploadImgRed();
            $uploadImg->uploadImagem($this->Foto, '../assets/imagens/sobre_autor/1/', $this->Dados['imagem'], 1200, 627);
            if ($uploadImg->getResultado()) {
                $apagarImg = new \App\adms\Models\helper\AdmsApagarImg();
                $apagarImg->apagarImg('../assets/imagens/sobre_autor/1/' . $this->ImgAntiga);
                $this->updateSobre();
            } else {
                $this->Resultado = false;
            }
        }
    }

    private function updateSobre()
    {
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upSobre = new \App\adms\Models\helper\AdmsUpdate();
        $upSobre->exeUpdate("sts_sobres", $this->Dados, "WHERE id =:id", "id=1");
        if ($upSobre->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Conteúdo sobre da página blog atualizado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Conteúdo sobre da página blog não foi atualizado!</div>";
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
