<?php

namespace App\adms\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class VerMenu
{

    private $Dados;
    private $DadosId;

    public function verMenu($DadosId = null)
    {

        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $verMenu = new \App\adms\Models\AdmsVerMenu();
            $this->Dados['dados_menu'] = $verMenu->verMenu($this->DadosId);

            $botao = ['list_menu' => ['menu_controller' => 'menu', 'menu_metodo' => 'listar'],
                'edit_menu' => ['menu_controller' => 'editar-menu', 'menu_metodo' => 'edit-menu'],
                'del_menu' => ['menu_controller' => 'apagar-menu', 'menu_metodo' => 'apagar-menu']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("adms/Views/menu/verMenu", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Item de menu não encontrado!</div>";
            $UrlDestino = URLADM . 'menu/listar';
            header("Location: $UrlDestino");
        }
    }

}
