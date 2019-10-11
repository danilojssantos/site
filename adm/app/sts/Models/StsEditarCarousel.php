<?php

namespace App\sts\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class StsEditarCarousel
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

    public function verCarousel($DadosId)
    {
        $this->DadosId = (int) $DadosId;
        $verCarousel = new \App\adms\Models\helper\AdmsRead();
        $verCarousel->fullRead("SELECT * FROM sts_carousels 
                WHERE id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verCarousel->getResultado();
        return $this->Resultado;
    }

    public function altCarousel(array $Dados)
    {
        $this->Dados = $Dados;
        //var_dump($this->Dados);
        $this->Foto = $this->Dados['imagem_nova'];
        $this->ImgAntiga = $this->Dados['imagem_antiga'];
        unset($this->Dados['imagem_nova'], $this->Dados['imagem_antiga']);

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->valCarousel();
        } else {
            $this->Resultado = false;
        }
    }

    private function valCarousel()
    {
        if (empty($this->Foto['name'])) {
            $this->updateEditCarousel();
        } else {
            $slugImg = new \App\adms\Models\helper\AdmsSlug();
            $this->Dados['imagem'] = $slugImg->nomeSlug($this->Foto['name']);

            $uploadImg = new \App\adms\Models\helper\AdmsUploadImgRed();
            $uploadImg->uploadImagem($this->Foto, '../assets/imagens/carousel/' . $this->Dados['id'] . '/', $this->Dados['imagem'], 1920, 846);
            if ($uploadImg->getResultado()) {
                $apagarImg = new \App\adms\Models\helper\AdmsApagarImg();
                $apagarImg->apagarImg('../assets/imagens/carousel/' . $this->Dados['id'] . '/' . $this->ImgAntiga);
                $this->updateEditCarousel();
            } else {
                $this->Resultado = false;
            }
        }
    }

    private function updateEditCarousel()
    {
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAltCarousel = new \App\adms\Models\helper\AdmsUpdate();
        $upAltCarousel->exeUpdate("sts_carousels", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);
        if ($upAltCarousel->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Slide do carousel atualizado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O slide do carousel não foi atualizado!</div>";
            $this->Resultado = false;
        }
    }

    public function listarCadastrar()
    {
        $listar = new \App\adms\Models\helper\AdmsRead();
        $listar->fullRead("SELECT id id_cr, nome nome_cr FROM adms_cors ORDER BY nome ASC");
        
        $registro['cr'] = $listar->getResultado();

        $listar->fullRead("SELECT id id_sit, nome nome_sit FROM adms_sits ORDER BY nome ASC");
        $registro['sit'] = $listar->getResultado();

        $this->Resultado = ['cr' => $registro['cr'], 'sit' => $registro['sit']];

        return $this->Resultado;
    }

}
