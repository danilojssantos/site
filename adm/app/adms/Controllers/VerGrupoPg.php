<?php

namespace App\adms\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class VerGrupoPg
{

    private $Dados;
    private $DadosId;

    public function verGrupoPg($DadosId = null)
    {

        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $verGrupoPg = new \App\adms\Models\AdmsVerGrupoPg();
            $this->Dados['dados_grpg'] = $verGrupoPg->verGrupoPg($this->DadosId);

            $botao = ['list_grpg' => ['menu_controller' => 'grupo-pg', 'menu_metodo' => 'listar'],
                'edit_grpg' => ['menu_controller' => 'editar-grupo-pg', 'menu_metodo' => 'edit-grupo-pg'],
                'del_grpg' => ['menu_controller' => 'apagar-grupo-pg', 'menu_metodo' => 'apagar-grupo-pg']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("adms/Views/grupoPg/verGrupoPg", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Grupo de página não encontrado!</div>";
            $UrlDestino = URLADM . 'grupo-pg/listar';
            header("Location: $UrlDestino");
        }
    }

}
