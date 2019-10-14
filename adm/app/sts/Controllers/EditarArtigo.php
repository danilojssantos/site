<?php

namespace App\sts\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class EditarArtigo
{

    private $Dados;
    private $DadosId;

    public function editArtigo($DadosId = null)
    {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $this->editArtigoPriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Artigo não encontrado!</div>";
            $UrlDestino = URLADM . 'artigo/listar';
            header("Location: $UrlDestino");
        }
    }

    private function editArtigoPriv()
    {
        if (!empty($this->Dados['EditArtigo'])) {
            unset($this->Dados['EditArtigo']);
            $this->Dados['imagem_nova'] = ($_FILES['imagem_nova'] ? $_FILES['imagem_nova'] : null);
            $editarArtigo = new \App\sts\Models\StsEditarArtigo();
            $editarArtigo->altArtigo($this->Dados);
            if ($editarArtigo->getResultado()) {
                $UrlDestino = URLADM . 'ver-artigo/ver-artigo/' . $this->Dados['id'];
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editArtigoViewPriv();
            }
        } else {
            $verArtigo = new \App\sts\Models\StsEditarArtigo();
            $this->Dados['form'] = $verArtigo->verArtigo($this->DadosId);
            $this->editArtigoViewPriv();
        }
    }

    private function editArtigoViewPriv()
    {
        if ($this->Dados['form']) {
            $listarSelect = new \App\sts\Models\StsEditarArtigo();
            $this->Dados['select'] = $listarSelect->listarCadastrar();
            
            $botao = ['vis_art' => ['menu_controller' => 'ver-artigo', 'menu_metodo' => 'ver-artigo'],
                'edit_autor_art' => ['menu_controller' => 'editar-autor-artigo', 'menu_metodo' => 'edit-autor-artigo']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            $carregarView = new \Core\ConfigView("sts/Views/artigo/editarArtigo", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Artigo não encontrado!</div>";
            $UrlDestino = URLADM . 'artigo/listar';
            header("Location: $UrlDestino");
        }
    }

}
