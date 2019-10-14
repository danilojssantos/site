<?php

namespace App\sts\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class CadastrarTipoPgSite
{

    private $Dados;

    public function cadTipoPgSite()
    {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->Dados['CadTipoPg'])) {
            unset($this->Dados['CadTipoPg']);
            $cadTipoPg = new \App\sts\Models\StsCadastrarTipoPgSite();
            $cadTipoPg->cadTipoPgSite($this->Dados);
            if ($cadTipoPg->getResultado()) {
                $UrlDestino = URLADM . 'tipo-pg-site/listar';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->cadTipoPgViewPriv();
            }
        } else {
            $this->cadTipoPgViewPriv();
        }
    }

    private function cadTipoPgViewPriv()
    {        
        $botao = ['list_tpg' => ['menu_controller' => 'tipo-pg-site', 'menu_metodo' => 'listar']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);
        
        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();
        $carregarView = new \Core\ConfigView("sts/Views/tipoPg/cadTipoPg", $this->Dados);
        $carregarView->renderizar();
    }

}
