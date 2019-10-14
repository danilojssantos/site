<?php

namespace App\sts\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class VerCatArtigo
{

    private $Dados;
    private $DadosId;

    public function verCatArtigo($DadosId = null)
    {

        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $verCatArtigo = new \App\sts\Models\StsVerCatArtigo();
            $this->Dados['dados_CatArtigo'] = $verCatArtigo->verCatArtigo($this->DadosId);

            $botao = ['list_cat_art' => ['menu_controller' => 'cat-artigo', 'menu_metodo' => 'listar'],
                'edit_cat_art' => ['menu_controller' => 'editar-cat-artigo', 'menu_metodo' => 'edit-cat-artigo'],
                'del_cat_art' => ['menu_controller' => 'apagar-cat-artigo', 'menu_metodo' => 'apagar-cat-artigo']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("sts/Views/catArtigo/verCatArtigo", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Categoria de artigo não encontrado!</div>";
            $UrlDestino = URLADM . 'cat-artigo/listar';
            header("Location: $UrlDestino");
        }
    }

}
