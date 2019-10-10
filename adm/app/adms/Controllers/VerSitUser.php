<?php

namespace App\adms\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class VerSitUser
{

    private $Dados;
    private $DadosId;

    public function verSitUser($DadosId = null)
    {

        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $verSitUser = new \App\adms\Models\AdmsVerSitUser();
            $this->Dados['dados_sit'] = $verSitUser->verSitUser($this->DadosId);

            $botao = ['list_sit' => ['menu_controller' => 'situacao-user', 'menu_metodo' => 'listar'],
                'edit_sit' => ['menu_controller' => 'editar-sit-user', 'menu_metodo' => 'edit-sit-user'],
                'del_sit' => ['menu_controller' => 'apagar-sit-user', 'menu_metodo' => 'apagar-sit-user']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("adms/Views/situacaoUser/verSitUser", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Situação de usuário não encontrado!</div>";
            $UrlDestino = URLADM . 'situacao-user/listar';
            header("Location: $UrlDestino");
        }
    }

}
