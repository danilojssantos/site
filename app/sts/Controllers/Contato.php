<?php

namespace App\sts\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class Contato
{

    private $Dados;

    public function index()
    {
        
        
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if(!empty($this->Dados['CadMsgCont'])){
            unset($this->Dados['CadMsgCont']);
            $cadContato = new \Sts\Models\StsContato();
            $cadContato->cadContato($this->Dados);
            

            if ($cadContato->getResultado()) {
                $this->Dados['form'] = null;
            }else{
                $this->Dados['form'] = $this->Dados;
            }
            
        }
        
        $listarMenu = new \Sts\Models\StsMenu();
        $this->Dados['menu'] = $listarMenu->listarMenu();
        
        $carregarView = new \Core\ConfigView('sts/Views/contato/contato', $this->Dados);
        $carregarView->renderizar();
    }

}

