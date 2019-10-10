<?php

namespace App\adms\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class VerSit
{

    private $Dados;
    private $DadosId;

    public function verSit($DadosId = null)
    {

        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $verSit = new \App\adms\Models\AdmsVerSit();
            $this->Dados['dados_sit'] = $verSit->verSit($this->DadosId);

            $botao = ['list_sit' => ['menu_controller' => 'situacao', 'menu_metodo' => 'listar'],
                'edit_sit' => ['menu_controller' => 'editar-sit', 'menu_metodo' => 'edit-sit'],
                'del_sit' => ['menu_controller' => 'apagar-sit', 'menu_metodo' => 'apagar-sit']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("adms/Views/situacao/verSit", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Situação não encontrado!</div>";
            $UrlDestino = URLADM . 'situacao/listar';
            header("Location: $UrlDestino");
        }
    }

}
