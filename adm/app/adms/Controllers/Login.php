<?php

namespace App\adms\Controllers;

if (!defined ('URL')) {
    header("Location /");
    exit();
}

class Login 
{
    private $Dados;
    public function acesso()
    {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
       // var_dump($this->Dados);
        
        if (!empty($this->Dados['SendLogin'])) {
             unset($this->Dados['SendLogin']);
             $visualLogin = new \App\adms\Models\AdmsLogin();
             $visualLogin->acesso($this->Dados);

             if ($visualLogin->getResultado()) {
                 $UrlDestino = URLADM . 'home/index';
                 header("Location: $UrlDestino");
                 exit();
             }else{
                $this->Dados['form'] = $this->Dados;
             }
            
        }


        $carregarView = new \Core\ConfigView("adms/Views/login/acesso",$this->Dados);

        $carregarView->renderizarLogin();
    }
}