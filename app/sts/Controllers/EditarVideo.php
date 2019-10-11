<?php

namespace App\sts\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class EditarVideo {

    private $Dados;

    public function editVideo() {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->Dados['EditVideo'])) {
            unset($this->Dados['EditVideo']);
            $editarVideo = new \App\sts\Models\StsEditarVideo();
            $editarVideo->altVideo($this->Dados);
            if ($editarVideo->getResultado()) {
                $UrlDestino = URLADM . 'editar-video/edit-video';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editVideoViewPriv();
            }
        } else {
            $verVideo = new \App\sts\Models\StsEditarVideo();
            $this->Dados['form'] = $verVideo->verVideo();
            $this->editVideoViewPriv();
        }
    }

    private function editVideoViewPriv() {
        if ($this->Dados['form']) {
            
            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            
            $carregarView = new \Core\ConfigView("sts/Views/video/editarVideo", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Formulário para editar os dados do vídeo não encontrado!</div>";
            $UrlDestino = URLADM . 'editar-video/edit-video';
            header("Location: $UrlDestino");
        }
    }

}
