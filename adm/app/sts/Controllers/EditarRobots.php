<?php

namespace App\sts\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class EditarRobots {

    private $Dados;
    private $DadosId;

    public function editRobots($DadosId = null) {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $this->editRobotsPriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Robots de página não encontrado!</div>";
            $UrlDestino = URLADM . 'robots/listar';
            header("Location: $UrlDestino");
        }
    }

    private function editRobotsPriv() {
        if (!empty($this->Dados['EditRobots'])) {
            unset($this->Dados['EditRobots']);
            $editarRobots = new \App\sts\Models\StsEditarRobots();
            $editarRobots->altRobots($this->Dados);
            if ($editarRobots->getResultado()) {
                $UrlDestino = URLADM . 'ver-robots/ver-robots/' . $this->Dados['id'];
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editRobotsViewPriv();
            }
        } else {
            $verRobots = new \App\sts\Models\StsEditarRobots();
            $this->Dados['form'] = $verRobots->verRobots($this->DadosId);
            $this->editRobotsViewPriv();
        }
    }

    private function editRobotsViewPriv() {
        if ($this->Dados['form']) {

            $botao = ['vis_robots' => ['menu_controller' => 'ver-robots', 'menu_metodo' => 'ver-robots']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            $carregarView = new \Core\ConfigView("sts/Views/robots/editarRobots", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Robots de página não encontrado!</div>";
            $UrlDestino = URLADM . 'robots/listar';
            header("Location: $UrlDestino");
        }
    }

}
