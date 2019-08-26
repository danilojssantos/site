<?php
namespace Sts\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}



class StsBlog
{

    private $Resutado;

    public function ListarArtigos()
    {
        $listar = new \Sts\Models\helper\StsRead();
        $listar->fullRead('SELECT id, titulo, descricao, imagem, slug FROM sts_artigos 
        WHERE adms_sit_id =:adms_sit_id
        ORDER BY id DESC
        LIMIT :limit', 'adms_sit_id=1&limit=5');
       
        
        $this->Resultado = $listar->getResultado();
       // var_dump($this->Resutado);
        return $this->Resultado;
    }

}