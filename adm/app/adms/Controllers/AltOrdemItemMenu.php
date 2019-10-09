<?php

namespace App\adms\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AltOrdemItemMenu
 *
 * @copyright (c) year, Cesar Szpak - Celke
 */
class AltOrdemItemMenu
{

    private $DadosId;

    public function altOrdemItemMenu($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
           $altOrdemMenu = new \App\adms\Models\AdmsAltOrdemItemMenu();
           $altOrdemMenu->altOrdemMenu($this->DadosId);
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Necessário selecionar um item de menu!</div>";
        }
        $UrlDestino = URLADM . 'menu/listar';
        header("Location: $UrlDestino");
    }

}
