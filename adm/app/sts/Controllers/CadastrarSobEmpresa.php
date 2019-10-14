<?php

namespace App\sts\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class CadastrarSobEmpresa
{

    private $Dados;

    public function cadSobEmpresa()
    {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->Dados['CadSobEmp'])) {
            unset($this->Dados['CadSobEmp']);
            $this->Dados['imagem_nova'] = ($_FILES['imagem_nova'] ? $_FILES['imagem_nova'] : null);
            $cadSobEmpresa = new \App\sts\Models\StsCadastrarSobEmpresa();
            $cadSobEmpresa->cadSobEmpresa($this->Dados);
            if ($cadSobEmpresa->getResultado()) {
                $UrlDestino = URLADM . 'sob-empresa/listar';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->cadSobEmpresaViewPriv();
            }
        } else {
            $this->cadSobEmpresaViewPriv();
        }
    }

    private function cadSobEmpresaViewPriv()
    {
        $listarSelect = new \App\sts\Models\StsCadastrarSobEmpresa();
        $this->Dados['select'] = $listarSelect->listarCadastrar();
       
        $botao = ['list_sob_emp' => ['menu_controller' => 'sob-empresa', 'menu_metodo' => 'listar']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);
        
        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();
        $carregarView = new \Core\ConfigView("sts/Views/sobEmpresa/cadSobEmpresa", $this->Dados);
        $carregarView->renderizar();
    }

}
