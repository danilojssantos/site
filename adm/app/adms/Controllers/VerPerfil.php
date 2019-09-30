<?php 

namespace App\adms\Controllers;
if (!defined('URL')) {
    header("Location: /");
    exit();
}

class VerPerfil
{
    private $Dados;

    public function perfil()
    {
        $verPerfil = new \App\adms\Models\AdmsVerPerfil();
        $this->Dados['dados_perfil'] = $verPerfil->verPerfil();

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu']= $listarMenu->itemMenu();

        
        $carregarView = new \Core\ConfigView("adms/Views/usuario/perfil", $this->Dados);
        $carregarView->renderizar();
    }
}