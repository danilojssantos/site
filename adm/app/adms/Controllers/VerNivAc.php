<?php

namespace App\adms\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class VerNivAc
{

    private $Dados;
    private $DadosId;

    public function verNivAc($DadosId = null)
    {

        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $verNivAc = new \App\adms\Models\AdmsVerNivAc();
            $this->Dados['dados_nivac'] = $verNivAc->verNivAc($this->DadosId);

            $botao = ['list_nivac' => ['menu_controller' => 'nivel-acesso', 'menu_metodo' => 'listar'],
                'edit_nivac' => ['menu_controller' => 'editar-niv-ac', 'menu_metodo' => 'edit-niv-ac'],
                'del_nivac' => ['menu_controller' => 'apagar-niv-ac', 'menu_metodo' => 'apagar-niv-ac']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("adms/Views/nivAcesso/verNivAc", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Nivel de acesso não encontrado!</div>";
            $UrlDestino = URLADM . 'nivel-acesso/listar';
            header("Location: $UrlDestino");
        }
    }

}
