<?php

namespace App\adms\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class VerSitPg
{

    private $Dados;
    private $DadosId;

    public function verSitPg($DadosId = null)
    {

        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $verSitPg = new \App\adms\Models\AdmsVerSitPg();
            $this->Dados['dados_sit'] = $verSitPg->verSitPg($this->DadosId);

            $botao = ['list_sit' => ['menu_controller' => 'situacao-pg', 'menu_metodo' => 'listar'],
                'edit_sit' => ['menu_controller' => 'editar-sit-pg', 'menu_metodo' => 'edit-sit-pg'],
                'del_sit' => ['menu_controller' => 'apagar-sit-pg', 'menu_metodo' => 'apagar-sit-pg']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("adms/Views/situacaoPg/verSitPg", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Situação de página não encontrado!</div>";
            $UrlDestino = URLADM . 'situacao-pg/listar';
            header("Location: $UrlDestino");
        }
    }

}
