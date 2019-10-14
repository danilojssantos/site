<?php

namespace App\sts\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class EditarAutorArtigo {

    private $Dados;
    private $DadosId;

    public function editAutorArtigo($DadosId = null) {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $this->editAutorArtigoPriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Artigo não encontrado!</div>";
            $UrlDestino = URLADM . 'artigo/listar';
            header("Location: $UrlDestino");
        }
    }

    private function editAutorArtigoPriv() {
        if (!empty($this->Dados['EditAutorArtigo'])) {
            unset($this->Dados['EditAutorArtigo']);
            $editarAutorArtigo = new \App\sts\Models\StsEditarAutorArtigo();
            $editarAutorArtigo->altAutorArtigo($this->Dados);
            if ($editarAutorArtigo->getResultado()) {
                $UrlDestino = URLADM . 'ver-artigo/ver-artigo/' . $this->Dados['id'];
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editAutorArtigoViewPriv();
            }
        } else {
            $verAutorArtigo = new \App\sts\Models\StsEditarAutorArtigo();
            $this->Dados['form'] = $verAutorArtigo->verAutorArtigo($this->DadosId);
            $this->editAutorArtigoViewPriv();
        }
    }

    private function editAutorArtigoViewPriv() {
        if ($this->Dados['form']) {
            $listarSelect = new \App\sts\Models\StsEditarAutorArtigo();
            $this->Dados['select'] = $listarSelect->listarCadastrar();

            $botao = ['vis_art' => ['menu_controller' => 'ver-artigo', 'menu_metodo' => 'ver-artigo']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            $carregarView = new \Core\ConfigView("sts/Views/artigo/editarAutorArtigo", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Artigo não encontrado!</div>";
            $UrlDestino = URLADM . 'artigo/listar';
            header("Location: $UrlDestino");
        }
    }

}
