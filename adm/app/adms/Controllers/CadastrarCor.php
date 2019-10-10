<?php

namespace App\adms\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class CadastrarCor
{

    private $Dados;

    public function cadCor()
    {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->Dados['CadCor'])) {
            unset($this->Dados['CadCor']);
            $cadCor = new \App\adms\Models\AdmsCadastrarCor();
            $cadCor->cadCor($this->Dados);
            if ($cadCor->getResultado()) {
                $UrlDestino = URLADM . 'cor/listar';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->cadCorViewPriv();
            }
        } else {
            $this->cadCorViewPriv();
        }
    }

    private function cadCorViewPriv()
    {
        $botao = ['list_cor' => ['menu_controller' => 'cor', 'menu_metodo' => 'listar']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);
        
        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();
        $carregarView = new \Core\ConfigView("adms/Views/cor/cadCor", $this->Dados);
        $carregarView->renderizar();
    }

}
