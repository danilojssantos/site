<?php

namespace App\sts\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class EditarCatArtigo {

    private $Dados;
    private $DadosId;

    public function editCatArtigo($DadosId = null) {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $this->editCatArtigoPriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Categoria de artigo não encontrado!</div>";
            $UrlDestino = URLADM . 'cat-artigo/listar';
            header("Location: $UrlDestino");
        }
    }

    private function editCatArtigoPriv() {
        if (!empty($this->Dados['EditCatArtigo'])) {
            unset($this->Dados['EditCatArtigo']);
            $editarCatArtigo = new \App\sts\Models\StsEditarCatArtigo();
            $editarCatArtigo->altCatArtigo($this->Dados);
            if ($editarCatArtigo->getResultado()) {
                $UrlDestino = URLADM . 'ver-cat-artigo/ver-cat-artigo/' . $this->Dados['id'];
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editCatArtigoViewPriv();
            }
        } else {
            $verCatArtigo = new \App\sts\Models\StsEditarCatArtigo();
            $this->Dados['form'] = $verCatArtigo->verCatArtigo($this->DadosId);
            $this->editCatArtigoViewPriv();
        }
    }

    private function editCatArtigoViewPriv() {
        if ($this->Dados['form']) {
            $listarSelect = new \App\sts\Models\StsEditarCatArtigo();
            $this->Dados['select'] = $listarSelect->listarCadastrar();

            $botao = ['vis_cat_art' => ['menu_controller' => 'ver-cat-artigo', 'menu_metodo' => 'ver-cat-artigo']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            $carregarView = new \Core\ConfigView("sts/Views/catArtigo/editarCatArtigo", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Categoria de artigo não encontrado!</div>";
            $UrlDestino = URLADM . 'cat-artigo/listar';
            header("Location: $UrlDestino");
        }
    }

}
