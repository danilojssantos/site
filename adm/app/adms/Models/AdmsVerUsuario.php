<?php


namespace App\adms\Models;
if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AdmsVerUsuario
{
    private $Resultado;
    private $DadosId;
    
    public function verUsuario($DadosId)
    {
        $this->DadosId = (int) $DadosId;
        $verPerfil = new \App\adms\Models\helper\AdmsRead();
        $verPerfil->fullRead("SELECT * FROM adms_usuarios WHERE id =:id LIMIT :limit", "id=".$this->DadosId."&limit=1");
        
        $this->Resultado= $verPerfil->getResultado();
        return $this->Resultado;
    }
}