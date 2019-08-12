<?php


namespace Sts\Models;

if (!defined('URL')){
    header('Location: /');
    exit();
}

class StsHome
{

    //função para listar os Dados 
    public function index()
    {
        echo "listar Dados <br>";
        $conexao = new \Sts\Models\helper\StsConn();
        $conexao->getConn();
    }

}