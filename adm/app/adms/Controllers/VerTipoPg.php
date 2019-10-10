<?php

namespace App\adms\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class VerTipoPg
{

    private $Dados;
    private $DadosId;

    public function verTipoPg($DadosId = null)
    {

        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $verTipoPg = new \App\adms\Models\AdmsVerTipoPg();
            $this->Dados['dados_tpg'] = $verTipoPg->verTipoPg($this->DadosId);

            $botao = ['list_tpg' => ['menu_controller' => 'tipo-pg', 'menu_metodo' => 'listar'],
                'edit_tpg' => ['menu_controller' => 'editar-tipo-pg', 'menu_metodo' => 'edit-tipo-pg'],
                'del_tpg' => ['menu_controller' => 'apagar-tipo-pg', 'menu_metodo' => 'apagar-tipo-pg']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("adms/Views/tipoPg/verTipoPg", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Tipo de página não encontrado!</div>";
            $UrlDestino = URLADM . 'tipo-pg/listar';
            header("Location: $UrlDestino");
        }
    }

}
