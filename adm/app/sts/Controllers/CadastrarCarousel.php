<?php

namespace App\sts\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class CadastrarCarousel
{

    private $Dados;

    public function cadCarousel()
    {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->Dados['CadCarousel'])) {
            unset($this->Dados['CadCarousel']);
            $this->Dados['imagem_nova'] = ($_FILES['imagem_nova'] ? $_FILES['imagem_nova'] : null);
            $cadCarousel = new \App\sts\Models\StsCadastrarCarousel();
            $cadCarousel->cadCarousel($this->Dados);
            if ($cadCarousel->getResultado()) {
                $UrlDestino = URLADM . 'carousel/listar';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->cadCarouselViewPriv();
            }
        } else {
            $this->cadCarouselViewPriv();
        }
    }

    private function cadCarouselViewPriv()
    {
        $listarSelect = new \App\sts\Models\StsCadastrarCarousel();
        $this->Dados['select'] = $listarSelect->listarCadastrar();
       
        $botao = ['list_carousel' => ['menu_controller' => 'carousel', 'menu_metodo' => 'listar']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);
        
        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();
        $carregarView = new \Core\ConfigView("sts/Views/carousel/cadCarousel", $this->Dados);
        $carregarView->renderizar();
    }

}
