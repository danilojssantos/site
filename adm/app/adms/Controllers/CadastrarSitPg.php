<?php

namespace App\adms\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class CadastrarSitPg
{

    private $Dados;

    public function cadSitPg()
    {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->Dados['CadSitPg'])) {
            unset($this->Dados['CadSitPg']);
            $cadSitPg = new \App\adms\Models\AdmsCadastrarSitPg();
            $cadSitPg->cadSitPg($this->Dados);
            if ($cadSitPg->getResultado()) {
                $UrlDestino = URLADM . 'situacao-pg/listar';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->cadSitPgViewPriv();
            }
        } else {
            $this->cadSitPgViewPriv();
        }
    }

    private function cadSitPgViewPriv()
    {        
        $botao = ['list_sit' => ['menu_controller' => 'situacao-pg', 'menu_metodo' => 'listar']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);
        
        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();
        $carregarView = new \Core\ConfigView("adms/Views/situacaoPg/cadSitPg", $this->Dados);
        $carregarView->renderizar();
    }

}
