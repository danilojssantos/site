<?php

namespace App\sts\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class VerSobEmpresa
{

    private $Dados;
    private $DadosId;

    public function verSobEmpresa($DadosId = null)
    {

        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $verSobEmpresa = new \App\sts\Models\StsVerSobEmpresa();
            $this->Dados['dados_SobEmpresa'] = $verSobEmpresa->verSobEmpresa($this->DadosId);

            $botao = ['list_sob_emp' => ['menu_controller' => 'sob-empresa', 'menu_metodo' => 'listar'],
                'edit_sob_emp' => ['menu_controller' => 'editar-sob-empresa', 'menu_metodo' => 'edit-sob-empresa'],
                'del_sob_emp' => ['menu_controller' => 'apagar-sob-empresa', 'menu_metodo' => 'apagar-sob-empresa']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("sts/Views/sobEmpresa/verSobEmpresa", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Sobre empresa não encontrado!</div>";
            $UrlDestino = URLADM . 'sob-empresa/listar';
            header("Location: $UrlDestino");
        }
    }

}
