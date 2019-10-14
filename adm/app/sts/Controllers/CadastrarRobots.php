<?php

namespace App\sts\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class CadastrarRobots
{

    private $Dados;

    public function cadRobots()
    {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->Dados['CadRobots'])) {
            unset($this->Dados['CadRobots']);
            $cadRobots = new \App\sts\Models\StsCadastrarRobots();
            $cadRobots->cadRobots($this->Dados);
            if ($cadRobots->getResultado()) {
                $UrlDestino = URLADM . 'robots/listar';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->cadRobotsViewPriv();
            }
        } else {
            $this->cadRobotsViewPriv();
        }
    }

    private function cadRobotsViewPriv()
    {        
        $botao = ['list_robots' => ['menu_controller' => 'robots', 'menu_metodo' => 'listar']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);
        
        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();
        $carregarView = new \Core\ConfigView("sts/Views/robots/cadRobots", $this->Dados);
        $carregarView->renderizar();
    }

}
