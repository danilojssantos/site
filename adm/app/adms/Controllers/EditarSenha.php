<?php

namespace App\adms\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class EditarSenha
{

    private $Dados;
    private $DadosId;

    public function editSenha($DadosId = null)
    {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $validaUsuario = new \App\adms\Models\AdmsEditarSenha();
            $validaUsuario->valUsuario($this->DadosId);
            if ($validaUsuario->getResultado()) {
                $this->editSenhaPriv();
            } else {
                $UrlDestino = URLADM . 'usuarios/listar';
                header("Location: $UrlDestino");
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Usuário não encontrado!</div>";
            $UrlDestino = URLADM . 'usuarios/listar';
            header("Location: $UrlDestino");
        }
    }

    private function editSenhaPriv()
    {
        if (!empty($this->Dados['EditSenha'])) {
            unset($this->Dados['EditSenha']);
            $editarSenha = new \App\adms\Models\AdmsEditarSenha();
            $editarSenha->editSenha($this->Dados);
            if ($editarSenha->getResultado()) {
                $_SESSION['msg'] = "<div class='alert alert-success'>Senha editada com sucesso!</div>";
                $UrlDestino = URLADM . 'ver-usuario/ver-usuario/' . $this->Dados['id'];
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados['id'];
                $this->editSenhaViewPriv();
            }
        } else {
            $this->Dados['form'] = $this->DadosId;
            $this->editSenhaViewPriv();
        }
    }

    private function editSenhaViewPriv()
    {
        if ($this->Dados['form']) {
            $botao = ['vis_usuario' => ['menu_controller' => 'ver-usuario', 'menu_metodo' => 'ver-usuario']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("adms/Views/usuario/editarSenha", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Usuário não encontrado!</div>";
            $UrlDestino = URLADM . 'usuarios/listar';
            header("Location: $UrlDestino");
        }
    }

}
