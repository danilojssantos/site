<?php

namespace App\adms\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class CadastrarGrupoPg
{

    private $Dados;

    public function cadGrupoPg()
    {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->Dados['CadGrupoPg'])) {
            unset($this->Dados['CadGrupoPg']);
            $cadGrupoPg = new \App\adms\Models\AdmsCadastrarGrupoPg();
            $cadGrupoPg->cadGrupoPg($this->Dados);
            if ($cadGrupoPg->getResultado()) {
                $UrlDestino = URLADM . 'grupo-pg/listar';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->cadGrupoPgViewPriv();
            }
        } else {
            $this->cadGrupoPgViewPriv();
        }
    }

    private function cadGrupoPgViewPriv()
    {        
        $botao = ['list_grpg' => ['menu_controller' => 'grupo-pg', 'menu_metodo' => 'listar']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);
        
        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();
        $carregarView = new \Core\ConfigView("adms/Views/grupoPg/cadGrupoPg", $this->Dados);
        $carregarView->renderizar();
    }

}
