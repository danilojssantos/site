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
      //  echo "listar Dados <br>";
     //   $conexao = new \Sts\Models\helper\StsConn();
      //  $conexao->getConn();

      $listar = new \Sts\Models\helper\StsRead();
      $listar->exeRead('sts_carousels', 'WHERE adms_situacoe_id =:adms_situacoe_id LIMIT :limit', 'adms_situacoe_id=1&limit=4');
      
    
    }

}