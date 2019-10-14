<?php

namespace App\sts\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class Robots
{

    private $Dados;
    private $PageId;

    public function listar($PageId = null)
    {
        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['cad_robots' => ['menu_controller' => 'cadastrar-robots', 'menu_metodo' => 'cad-robots'],
            'vis_robots' => ['menu_controller' => 'ver-robots', 'menu_metodo' => 'ver-robots'],
            'edit_robots' => ['menu_controller' => 'editar-robots', 'menu_metodo' => 'edit-robots'],
            'del_robots' => ['menu_controller' => 'apagar-robots', 'menu_metodo' => 'apagar-robots']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarRobots = new \App\sts\Models\StsListarRobots();
        $this->Dados['listRobots'] = $listarRobots->listarRobots($this->PageId);
        $this->Dados['paginacao'] = $listarRobots->getResultadoPg();
        
        $carregarView = new \Core\ConfigView("sts/Views/robots/listarRobots", $this->Dados);
        $carregarView->renderizar();
    }

}
