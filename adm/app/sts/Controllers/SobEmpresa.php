<?php

namespace App\sts\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class SobEmpresa
{

    private $Dados;
    private $PageId;

    public function listar($PageId = null)
    {
        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['cad_sob_emp' => ['menu_controller' => 'cadastrar-sob-empresa', 'menu_metodo' => 'cad-sob-empresa'],
            'vis_sob_emp' => ['menu_controller' => 'ver-sob-empresa', 'menu_metodo' => 'ver-sob-empresa'],
            'edit_sob_emp' => ['menu_controller' => 'editar-sob-empresa', 'menu_metodo' => 'edit-sob-empresa'],
            'del_sob_emp' => ['menu_controller' => 'apagar-sob-empresa', 'menu_metodo' => 'apagar-sob-empresa'],
            'ordem_sob_emp' => ['menu_controller' => 'alt-ordem-sob-empresa', 'menu_metodo' => 'alt-ordem-sob-empresa'],
            'alt_sit_sob_emp' => ['menu_controller' => 'alt-sit-sob-empresa', 'menu_metodo' => 'alt-sit-sob-empresa']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarSobEmpresa = new \App\sts\Models\StsListarSobEmpresa();
        $this->Dados['listSobEmpresa'] = $listarSobEmpresa->listarSobEmpresa($this->PageId);
        $this->Dados['paginacao'] = $listarSobEmpresa->getResultadoPg();
        
        $carregarView = new \Core\ConfigView("sts/Views/sobEmpresa/listarSobEmpresa", $this->Dados);
        $carregarView->renderizar();
    }

}
