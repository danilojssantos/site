<?php
namespace Sts\Controllers;
if(!defined('URL')){
    header("Location: /");
    exit();
}


class SobreDanilo
{
    private $Dados;
    public function index()
    {
        //listar na pagina 

        $listarSobDan = new \Sts\Models\StsSobreDan();
        $this->Dados['sts_sobs_emps'] = $listarSobDan->listarSobDan();

        $carregarView = new \Core\ConfigView("sts/Views/sobredanilo/sobredanilo",$this->Dados);
        $carregarView->renderizar();
    }
}