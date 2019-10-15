<?php

namespace App\sts\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class VerTipoPgSite
{

    private $Dados;
    private $DadosId;

    public function verTipoPgSite($DadosId = null)
    {

        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $verTipoPg = new \App\sts\Models\StsVerTipoPgSite();
            $this->Dados['dados_tpg'] = $verTipoPg->verTipoPgSite($this->DadosId);

            $botao = ['list_tpg' => ['menu_controller' => 'tipo-pg-site', 'menu_metodo' => 'listar'],
                'edit_tpg' => ['menu_controller' => 'editar-tipo-pg-site', 'menu_metodo' => 'edit-tipo-pg-site'],
                'del_tpg' => ['menu_controller' => 'apagar-tipo-pg-site', 'menu_metodo' => 'apagar-tipo-pg-site']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("sts/Views/tipoPg/verTipoPg", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Tipo de página não encontrado!</div>";
            $UrlDestino = URLADM . 'tipo-pg-site/listar';
            header("Location: $UrlDestino");
        }
    }

}
