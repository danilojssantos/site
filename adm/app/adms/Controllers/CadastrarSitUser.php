<?php

namespace App\adms\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class CadastrarSitUser
{

    private $Dados;

    public function cadSitUser()
    {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->Dados['CadSitUser'])) {
            unset($this->Dados['CadSitUser']);
            $cadSitUser = new \App\adms\Models\AdmsCadastrarSitUser();
            $cadSitUser->cadSitUser($this->Dados);
            if ($cadSitUser->getResultado()) {
                $UrlDestino = URLADM . 'situacao-user/listar';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->cadSitUserViewPriv();
            }
        } else {
            $this->cadSitUserViewPriv();
        }
    }

    private function cadSitUserViewPriv()
    {
        $listarSelect = new \App\adms\Models\AdmsCadastrarSitUser();
        $this->Dados['select'] = $listarSelect->listarCadastrar();
        
        $botao = ['list_sit' => ['menu_controller' => 'situacao-user', 'menu_metodo' => 'listar']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);
        
        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();
        $carregarView = new \Core\ConfigView("adms/Views/situacaoUser/cadSitUser", $this->Dados);
        $carregarView->renderizar();
    }

}
