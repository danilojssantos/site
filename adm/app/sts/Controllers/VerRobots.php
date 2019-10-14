<?php

namespace App\sts\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class VerRobots
{

    private $Dados;
    private $DadosId;

    public function verRobots($DadosId = null)
    {

        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $verRobots = new \App\sts\Models\StsVerRobots();
            $this->Dados['dados_Robots'] = $verRobots->verRobots($this->DadosId);

            $botao = ['list_robots' => ['menu_controller' => 'robots', 'menu_metodo' => 'listar'],
                'edit_robots' => ['menu_controller' => 'editar-robots', 'menu_metodo' => 'edit-robots'],
                'del_robots' => ['menu_controller' => 'apagar-robots', 'menu_metodo' => 'apagar-robots']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("sts/Views/robots/verRobots", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Robots da Página não encontrado!</div>";
            $UrlDestino = URLADM . 'robots/listar';
            header("Location: $UrlDestino");
        }
    }

}
