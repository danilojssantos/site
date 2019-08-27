<?php
namespace Sts\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class StsBlog
{

    private $Resutado;
    private $PageId;

    public function listarArtigos($PageId = null)
    {
        $this->PageId = (int) $PageId;
        $paginacao = new \Sts\Models\helper\StsPaginacao(URL . 'blog');
        //depois lembrar de troca 3 por 5
        $paginacao->condicao($this->PageId, 3);
        //listar a paginacao 
        $paginacao->paginacao('SELECT COUNT (id) AS num_result FROM sts_artigos WHERE  adms_sit_id =:adms_sit_id' ,'adms_sit_id=1');


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