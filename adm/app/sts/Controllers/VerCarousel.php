<?php

namespace App\sts\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class VerCarousel
{

    private $Dados;
    private $DadosId;

    public function verCarousel($DadosId = null)
    {

        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $verCarousel = new \App\sts\Models\StsVerCarousel();
            $this->Dados['dados_carousel'] = $verCarousel->verCarousel($this->DadosId);

            $botao = ['list_carousel' => ['menu_controller' => 'carousel', 'menu_metodo' => 'listar'],
                'edit_carousel' => ['menu_controller' => 'editar-carousel', 'menu_metodo' => 'edit-carousel'],
                'del_carousel' => ['menu_controller' => 'apagar-carousel', 'menu_metodo' => 'apagar-carousel']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("sts/Views/carousel/verCarousel", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Slide de carousel não encontrado!</div>";
            $UrlDestino = URLADM . 'carousel/listar';
            header("Location: $UrlDestino");
        }
    }

}
