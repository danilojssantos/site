<?php

namespace App\sts\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class CadastrarTpArtigo
{

    private $Dados;

    public function cadTpArtigo()
    {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->Dados['CadTpArt'])) {
            unset($this->Dados['CadTpArt']);
            $cadTpArtigo = new \App\sts\Models\StsCadastrarTpArtigo();
            $cadTpArtigo->cadTpArtigo($this->Dados);
            if ($cadTpArtigo->getResultado()) {
                $UrlDestino = URLADM . 'tp-artigo/listar';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->cadTpArtigoViewPriv();
            }
        } else {
            $this->cadTpArtigoViewPriv();
        }
    }

    private function cadTpArtigoViewPriv()
    {        
        $botao = ['list_tp_artigo' => ['menu_controller' => 'tp-artigo', 'menu_metodo' => 'listar']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);
        
        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();
        $carregarView = new \Core\ConfigView("sts/Views/tpArtigo/cadTpArtigo", $this->Dados);
        $carregarView->renderizar();
    }

}
