<?php

namespace App\sts\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of Home
 *
 * @copyright (c) year, Cesar Szpak - Celke
 */
class Home
{

    private $Dados;

    public function index()
    {
        $listarMenu = new \Sts\Models\StsMenu();
        $this->Dados['menu'] = $listarMenu->listarMenu();

        $listar_car = new \Sts\Models\StsCarousel();
        $this->Dados['sts_carousels'] = $listar_car->listar();

        $listar_ser = new \Sts\Models\StsServico();
        $this->Dados['sts_servicos'] = $listar_ser->listar();

        $listar_vid = new \Sts\Models\StsVideo();
        $this->Dados['sts_videos'] = $listar_vid->listar();

        $listar_art_home = new \Sts\Models\StsArtHome();
        $this->Dados['sts_artigos'] = $listar_art_home->listarArtHome();

        $carregarView = new \Core\ConfigView("sts/Views/home/home", $this->Dados);
        $carregarView->renderizar();
    }

}
