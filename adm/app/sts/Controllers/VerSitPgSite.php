<?php

namespace App\sts\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class VerSitPgSite
{

    private $Dados;
    private $DadosId;

    public function verSitPgSite($DadosId = null)
    {

        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $verSitPgSite = new \App\sts\Models\StsSitPgSite();
            $this->Dados['dados_SitPgSite'] = $verSitPgSite->verSitPgSite($this->DadosId);

            $botao = ['list_sit_pg' => ['menu_controller' => 'sit-pg-site', 'menu_metodo' => 'listar'],
                'edit_sit_pg' => ['menu_controller' => 'editar-sit-pg-site', 'menu_metodo' => 'edit-sit-pg-site'],
                'del_sit_pg' => ['menu_controller' => 'apagar-sit-pg-site', 'menu_metodo' => 'apagar-sit-pg-site']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("sts/Views/sitPgSite/verSitPgSite", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Situação de pagina do site não encontrado!</div>";
            $UrlDestino = URLADM . 'sit-pg-site/listar';
            header("Location: $UrlDestino");
        }
    }

}
