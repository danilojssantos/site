<?php

namespace Sts\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}




class StsContato
{
    private $Resultado;
    private $Dados;

    public function cadContato(array $Dados){
        $this->Dados = $Dados;
        $cadContato = new \Sts\Models\helper\StsCreate();
        $cadContato->exeCreate('sts_contatos', $this->Dados);
        
        if ($cadContato->getResultado()) {
            $_SESSION['msg'] ="<div class='alert alert-success'>Mensagem Enviada com sucesso!</div>";
        } else {
            $_SESSION['msg'] ="<div class='alert alert-danger'>Mensagem não foi Enviada !</div>";
        }
    }

    

    
}
