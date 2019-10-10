<?php

namespace App\adms\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class CadastrarTipoPg
{

    private $Dados;

    public function cadTipoPg()
    {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->Dados['CadTipoPg'])) {
            unset($this->Dados['CadTipoPg']);
            $cadTipoPg = new \App\adms\Models\AdmsCadastrarTipoPg();
            $cadTipoPg->cadTipoPg($this->Dados);
            if ($cadTipoPg->getResultado()) {
                $UrlDestino = URLADM . 'tipo-pg/listar';
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
        $botao = ['list_tpg' => ['menu_controller' => 'tipo-pg', 'menu_metodo' => 'listar']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);
        
        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();
        $carregarView = new \Core\ConfigView("adms/Views/tipoPg/cadTipoPg", $this->Dados);
        $carregarView->renderizar();
    }

}
