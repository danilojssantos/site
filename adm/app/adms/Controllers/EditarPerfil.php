<?php

namespace App\adms\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class EditarPerfil
{

    private $Dados;

    public function altPerfil()
    {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->Dados['EdiPerfil'])) {
            unset($this->Dados['EdiPerfil']);
           var_dump($this->Dados);
            $altPerfilBd = new \App\adms\Models\AdmsEditarPerfil();
           
            $altPerfilBd->altPerfil($this->Dados);
            if ($altPerfilBd->getResultado()) {
                $UrlDestino = URLADM . 'ver-perfil/perfil';
                header("Location: $UrlDestino");                
            } else {
                $this->Dados['form'] = $this->Dados;
                $listarMenu = new \App\adms\Models\AdmsMenu();
                $this->Dados['menu'] = $listarMenu->itemMenu();
                $carregarView = new \Core\ConfigView("adms/Views/usuario/editPerfil", $this->Dados);
                $carregarView->renderizar();
            }
        } else {
            $this->Dados['form'] = $this->Dados;
            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            $carregarView = new \Core\ConfigView("adms/Views/usuario/editPerfil", $this->Dados);
            $carregarView->renderizar();
        }
    }

}
