<?php

namespace App\sts\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class StsEditarVideo
{

    private $Resultado;
    private $Dados;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function verVideo()
    {
        $verVideo = new \App\adms\Models\helper\AdmsRead();
        $verVideo->fullRead("SELECT * FROM sts_videos
                WHERE id =:id LIMIT :limit", "id=1&limit=1");
        $this->Resultado = $verVideo->getResultado();
        return $this->Resultado;
    }

    public function altVideo(array $Dados)
    {
        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazioComTag;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->updateVideo();
        } else {
            $this->Resultado = false;
        }
    }

    private function updateVideo()
    {
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upVideo = new \App\adms\Models\helper\AdmsUpdate();
        $upVideo->exeUpdate("sts_videos", $this->Dados, "WHERE id =:id", "id=1");
        if ($upVideo->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Formulário para editar os dados do vídeo atualizado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Formulário para editar os dados do vídeo não foi atualizado!</div>";
            $this->Resultado = false;
        }
    }
    

}
