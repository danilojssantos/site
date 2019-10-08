<?php

namespace App\adms\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class CadastrarNivAc
{

    private $Dados;

    public function cadNivAc()
    {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->Dados['CadNivAc'])) {
            unset($this->Dados['CadNivAc']);
            $cadNivAc = new \App\adms\Models\AdmsCadastrarNivAc();
            $cadNivAc->cadNivAc($this->Dados);
            if ($cadNivAc->getResultado()) {
                $UrlDestino = URLADM . 'nivel-acesso/listar';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->cadNivAcViewPriv();
            }
        } else {
            $this->cadNivAcViewPriv();
        }
    }

    private function cadNivAcViewPriv()
    {
        $botao = ['list_nivac' => ['menu_controller' => 'nivel-acesso', 'menu_metodo' => 'listar']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);
        
        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();
        $carregarView = new \Core\ConfigView("adms/Views/nivAcesso/cadNivAc", $this->Dados);
        $carregarView->renderizar();
    }

}
