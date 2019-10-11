<?php

namespace App\sts\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class StsCadastrarCarousel
{

    private $Resultado;
    private $Dados;
    private $DadosId;
    private $Foto;
    private $UltimoCarousel;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function verCarousel($DadosId)
    {
        $this->DadosId = (int) $DadosId;
        $verCarousel = new \App\adms\Models\helper\AdmsRead();
        $verCarousel->fullRead("SELECT * FROM sts_carousels WHERE id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verCarousel->getResultado();
        return $this->Resultado;
    }

    public function cadCarousel(array $Dados)
    {
        $this->Dados = $Dados;
        $this->Foto = $this->Dados['imagem_nova'];
        unset($this->Dados['imagem_nova']);

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->inserirCarousel();
        } else {
            $this->Resultado = false;
        }
    }

    private function inserirCarousel()
    {   
        $this->Dados['created'] = date("Y-m-d H:i:s");
        $slugImg = new \App\adms\Models\helper\AdmsSlug();
        $this->Dados['imagem'] = $slugImg->nomeSlug($this->Foto['name']);
        $this->verUltimoCarousel();
        $this->Dados['ordem'] = $this->UltimoCarousel[0]['ordem'] + 1;

        $cadCarousel = new \App\adms\Models\helper\AdmsCreate;
        $cadCarousel->exeCreate("sts_carousels", $this->Dados);
        if ($cadCarousel->getResultado()) {
            if (empty($this->Foto['name'])) {
                $_SESSION['msg'] = "<div class='alert alert-success'>Slide do carousel cadastrado com sucesso!</div>";
                $this->Resultado = true;
            } else {
                $this->Dados['id'] = $cadCarousel->getResultado();
                $this->valFoto();
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O slide do carousel não foi cadastrado!</div>";
            $this->Resultado = false;
        }
    }
    
    private function verUltimoCarousel()
    {
        $verCarousel = new \App\adms\Models\helper\AdmsRead();
        $verCarousel->fullRead("SELECT ordem FROM sts_carousels ORDER BY ordem DESC LIMIT :limit", "limit=1");
        $this->UltimoCarousel = $verCarousel->getResultado();
    }

    private function valFoto()
    {
        $uploadImg = new \App\adms\Models\helper\AdmsUploadImgRed();
        $uploadImg->uploadImagem($this->Foto, '../assets/imagens/carousel/' . $this->Dados['id'] . '/', $this->Dados['imagem'], 1920, 846);
        if ($uploadImg->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Slide do carousel cadastrado com sucesso. Upload da imagem realizado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-info'>Erro: O slide do carousel não foi cadastrado. Erro ao realizar o upload da imagem!</div>";
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
