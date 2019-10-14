<?php

namespace App\sts\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class StsListarSobEmpresa
{

    private $Resultado;
    private $PageId;
    private $LimiteResultado = 10;
    private $ResultadoPg;
    
    function getResultadoPg()
    {
        return $this->ResultadoPg;
    }

    
    public function listarSobEmpresa($PageId = null)
    {
        $this->PageId = (int) $PageId;
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'sob-empresa/listar');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM sts_sobs_emps");
        $this->ResultadoPg = $paginacao->getResultado();
               
        $listarSobEmpresa = new \App\adms\Models\helper\AdmsRead();
        $listarSobEmpresa->fullRead("SELECT car.id, car.titulo, car.imagem, car.ordem,
                sit.nome nome_sit,
                cr.cor cor_cr
                FROM sts_sobs_emps car 
                INNER JOIN adms_sits sit ON sit.id=car.adms_sit_id
                INNER JOIN adms_cors cr ON cr.id=sit.adms_cor_id
                ORDER BY ordem ASC LIMIT :limit OFFSET :offset", "limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarSobEmpresa->getResultado();
        return $this->Resultado;
    }

}
