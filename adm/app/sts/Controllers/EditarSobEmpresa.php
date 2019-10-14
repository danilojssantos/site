<?php

namespace App\sts\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class EditarSobEmpresa
{

    private $Dados;
    private $DadosId;

    public function editSobEmpresa($DadosId = null)
    {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $this->editSobEmpresaPriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Sobre empresa não encontrado!</div>";
            $UrlDestino = URLADM . 'sob-empresa/listar';
            header("Location: $UrlDestino");
        }
    }

    private function editSobEmpresaPriv()
    {
        if (!empty($this->Dados['EditSobEmpresa'])) {
            unset($this->Dados['EditSobEmpresa']);
            $this->Dados['imagem_nova'] = ($_FILES['imagem_nova'] ? $_FILES['imagem_nova'] : null);
            $editarSobEmpresa = new \App\sts\Models\StsEditarSobEmpresa();
            $editarSobEmpresa->altSobEmpresa($this->Dados);
            if ($editarSobEmpresa->getResultado()) {
                $_SESSION['msg'] = "<div class='alert alert-success'>Sobre empresa editado com sucesso!</div>";
                $UrlDestino = URLADM . 'ver-sob-empresa/ver-sob-empresa/' . $this->Dados['id'];
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editSobEmpresaViewPriv();
            }
        } else {
            $verSobEmpresa = new \App\sts\Models\StsEditarSobEmpresa();
            $this->Dados['form'] = $verSobEmpresa->verSobEmpresa($this->DadosId);
            $this->editSobEmpresaViewPriv();
        }
    }

    private function editSobEmpresaViewPriv()
    {
        if ($this->Dados['form']) {
            $listarSelect = new \App\sts\Models\StsEditarSobEmpresa();
            $this->Dados['select'] = $listarSelect->listarCadastrar();
            
            $botao = ['vis_sob_emp' => ['menu_controller' => 'ver-sob-empresa', 'menu_metodo' => 'ver-sob-empresa']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            $carregarView = new \Core\ConfigView("sts/Views/sobEmpresa/editarSobEmpresa", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Sobre empresa não encontrado!</div>";
            $UrlDestino = URLADM . 'sob-empresa/listar';
            header("Location: $UrlDestino");
        }
    }

}
