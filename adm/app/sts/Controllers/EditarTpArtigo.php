<?php

namespace App\sts\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class EditarTpArtigo {

    private $Dados;
    private $DadosId;

    public function editTpArtigo($DadosId = null) {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $this->editTpArtigoPriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Tipo de artigo não encontrado!</div>";
            $UrlDestino = URLADM . 'tp-artigo/listar';
            header("Location: $UrlDestino");
        }
    }

    private function editTpArtigoPriv() {
        if (!empty($this->Dados['EditTpArt'])) {
            unset($this->Dados['EditTpArt']);
            $editarTpArtigo = new \App\sts\Models\StsEditarTpArtigo();
            $editarTpArtigo->altTpArtigo($this->Dados);
            if ($editarTpArtigo->getResultado()) {
                $UrlDestino = URLADM . 'ver-tp-artigo/ver-tp-artigo/' . $this->Dados['id'];
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editTpArtigoViewPriv();
            }
        } else {
            $verTpArtigo = new \App\sts\Models\StsEditarTpArtigo();
            $this->Dados['form'] = $verTpArtigo->verTpArtigo($this->DadosId);
            $this->editTpArtigoViewPriv();
        }
    }

    private function editTpArtigoViewPriv() {
        if ($this->Dados['form']) {

            $botao = ['vis_tp_artigo' => ['menu_controller' => 'ver-tp-artigo', 'menu_metodo' => 'ver-tp-artigo']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            $carregarView = new \Core\ConfigView("sts/Views/tpArtigo/editarTpArtigo", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Tipo de artigo não encontrado!</div>";
            $UrlDestino = URLADM . 'tp-artigo/listar';
            header("Location: $UrlDestino");
        }
    }

}
