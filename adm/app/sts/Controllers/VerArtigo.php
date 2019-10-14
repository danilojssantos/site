<?php

namespace App\sts\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class VerArtigo
{

    private $Dados;
    private $DadosId;

    public function verArtigo($DadosId = null)
    {

        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $verArtigo = new \App\sts\Models\StsVerArtigo();
            $this->Dados['dados_Artigo'] = $verArtigo->verArtigo($this->DadosId);

            $botao = ['list_art' => ['menu_controller' => 'artigo', 'menu_metodo' => 'listar'],
                'edit_art' => ['menu_controller' => 'editar-artigo', 'menu_metodo' => 'edit-artigo'],
                'edit_autor_art' => ['menu_controller' => 'editar-autor-artigo', 'menu_metodo' => 'edit-autor-artigo'],
                'del_art' => ['menu_controller' => 'apagar-artigo', 'menu_metodo' => 'apagar-artigo']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("sts/Views/artigo/verArtigo", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Artigo não encontrado!</div>";
            $UrlDestino = URLADM . 'artigo/listar';
            header("Location: $UrlDestino");
        }
    }

}
