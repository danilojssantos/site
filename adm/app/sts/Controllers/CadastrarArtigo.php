<?php

namespace App\sts\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class CadastrarArtigo
{

    private $Dados;

    public function cadArtigo()
    {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->Dados['CadArtigo'])) {
            unset($this->Dados['CadArtigo']);
            $this->Dados['imagem_nova'] = ($_FILES['imagem_nova'] ? $_FILES['imagem_nova'] : null);
            $cadArtigo = new \App\sts\Models\StsCadastrarArtigo();
            $cadArtigo->cadArtigo($this->Dados);
            if ($cadArtigo->getResultado()) {
                $UrlDestino = URLADM . 'artigo/listar';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->cadArtigoViewPriv();
            }
        } else {
            $this->cadArtigoViewPriv();
        }
    }

    private function cadArtigoViewPriv()
    {
        $listarSelect = new \App\sts\Models\StsCadastrarArtigo();
        $this->Dados['select'] = $listarSelect->listarCadastrar();
       
        $botao = ['list_art' => ['menu_controller' => 'artigo', 'menu_metodo' => 'listar'],
                'edit_autor_art' => ['menu_controller' => 'editar-autor-artigo', 'menu_metodo' => 'edit-autor-artigo']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);
        
        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();
        $carregarView = new \Core\ConfigView("sts/Views/artigo/cadArtigo", $this->Dados);
        $carregarView->renderizar();
    }

}
