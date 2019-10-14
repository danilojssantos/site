<?php

namespace App\sts\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class CadastrarCatArtigo
{

    private $Dados;

    public function cadCatArtigo()
    {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->Dados['CadCatArtigo'])) {
            unset($this->Dados['CadCatArtigo']);
            $cadCatArtigo = new \App\sts\Models\StsCadastrarCatArtigo();
            $cadCatArtigo->cadCatArtigo($this->Dados);
            if ($cadCatArtigo->getResultado()) {
                $UrlDestino = URLADM . 'cat-artigo/listar';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->cadCatArtigoViewPriv();
            }
        } else {
            $this->cadCatArtigoViewPriv();
        }
    }

    private function cadCatArtigoViewPriv()
    {
        $listarSelect = new \App\sts\Models\StsCadastrarCatArtigo();
        $this->Dados['select'] = $listarSelect->listarCadastrar();
       
        $botao = ['list_cat_art' => ['menu_controller' => 'cat-artigo', 'menu_metodo' => 'listar']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);
        
        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();
        $carregarView = new \Core\ConfigView("sts/Views/catArtigo/cadCatArtigo", $this->Dados);
        $carregarView->renderizar();
    }

}
