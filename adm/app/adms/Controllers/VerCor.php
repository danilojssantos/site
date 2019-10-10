<?php

namespace App\adms\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class VerCor
{

    private $Dados;
    private $DadosId;

    public function verCor($DadosId = null)
    {

        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $verCor = new \App\adms\Models\AdmsVerCor();
            $this->Dados['dados_cor'] = $verCor->vercor($this->DadosId);

            $botao = ['list_cor' => ['menu_controller' => 'cor', 'menu_metodo' => 'listar'],
                'edit_cor' => ['menu_controller' => 'editar-cor', 'menu_metodo' => 'edit-cor'],
                'del_cor' => ['menu_controller' => 'apagar-cor', 'menu_metodo' => 'apagar-cor']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("adms/Views/cor/verCor", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Cor não encontrada!</div>";
            $UrlDestino = URLADM . 'cor/listar';
            header("Location: $UrlDestino");
        }
    }

}
