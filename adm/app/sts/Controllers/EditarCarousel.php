<?php

namespace App\sts\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class EditarCarousel
{

    private $Dados;
    private $DadosId;

    public function editCarousel($DadosId = null)
    {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $this->editCarouselPriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Slide de carousel não encontrado!</div>";
            $UrlDestino = URLADM . 'carousel/listar';
            header("Location: $UrlDestino");
        }
    }

    private function editCarouselPriv()
    {
        if (!empty($this->Dados['EditCarousel'])) {
            unset($this->Dados['EditCarousel']);
            $this->Dados['imagem_nova'] = ($_FILES['imagem_nova'] ? $_FILES['imagem_nova'] : null);
            $editarCarousel = new \App\sts\Models\StsEditarCarousel();
            $editarCarousel->altCarousel($this->Dados);
            if ($editarCarousel->getResultado()) {
                $_SESSION['msg'] = "<div class='alert alert-success'>Slide de carousel editado com sucesso!</div>";
                $UrlDestino = URLADM . 'ver-carousel/ver-carousel/' . $this->Dados['id'];
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editCarouselViewPriv();
            }
        } else {
            $verCarousel = new \App\sts\Models\StsEditarCarousel();
            $this->Dados['form'] = $verCarousel->verCarousel($this->DadosId);
            $this->editCarouselViewPriv();
        }
    }

    private function editCarouselViewPriv()
    {
        if ($this->Dados['form']) {
            $listarSelect = new \App\sts\Models\StsEditarCarousel();
            $this->Dados['select'] = $listarSelect->listarCadastrar();
            
            $botao = ['vis_carousel' => ['menu_controller' => 'ver-carousel', 'menu_metodo' => 'ver-carousel']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            $carregarView = new \Core\ConfigView("sts/Views/carousel/editarCarousel", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Slide carousel não encontrado!</div>";
            $UrlDestino = URLADM . 'carousel/listar';
            header("Location: $UrlDestino");
        }
    }

}
