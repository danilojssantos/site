<?php

namespace App\adms\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class CadastrarUsuario
{

    private $Dados;

    public function cadUsuario()
    {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->Dados['CadUsuario'])) {
            unset($this->Dados['CadUsuario']);
            $this->Dados['imagem_nova'] = ($_FILES['imagem_nova'] ? $_FILES['imagem_nova'] : null);
            $cadUsuario = new \App\adms\Models\AdmsCadastrarUsuario();
            $cadUsuario->cadUsuario($this->Dados);
            if ($cadUsuario->getResultado()) {
                $UrlDestino = URLADM . 'usuarios/listar';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->cadUsuarioViewPriv();
            }
        } else {
            $this->cadUsuarioViewPriv();
        }
    }

    private function cadUsuarioViewPriv()
    {
        $listarSelect = new \App\adms\Models\AdmsCadastrarUsuario();
        $this->Dados['select'] = $listarSelect->listarCadastrar();
       
        $botao = ['list_usuario' => ['menu_controller' => 'usuarios', 'menu_metodo' => 'listar']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);
        
        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();
        $carregarView = new \Core\ConfigView("adms/Views/usuario/cadUsuario", $this->Dados);
        $carregarView->renderizar();
    }

}
