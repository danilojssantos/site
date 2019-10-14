<?php

namespace App\sts\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class Contato
{

    private $Dados;
    private $PageId;

    public function listar($PageId = null)
    {
        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['vis_contato' => ['menu_controller' => 'ver-contato', 'menu_metodo' => 'ver-contato'],
            'del_contato' => ['menu_controller' => 'apagar-contato', 'menu_metodo' => 'apagar-contato']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarContato = new \App\sts\Models\StsListarContato();
        $this->Dados['listContato'] = $listarContato->listarContato($this->PageId);
        $this->Dados['paginacao'] = $listarContato->getResultadoPg();
        
        $carregarView = new \Core\ConfigView("sts/Views/contato/listarContato", $this->Dados);
        $carregarView->renderizar();
    }

}
