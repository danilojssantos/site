<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AdmsListarUsuario
{

    private $Resultado;
    private $PageId;
    private $LimiteResultado = 2;
    private $ResultadoPg;
    
    function getResultadoPg()
    {
        return $this->ResultadoPg;
    }

    
    public function listarUsuario($PageId = null)
    {
        $this->PageId = (int) $PageId;
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'usuarios/listar');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result
                FROM adms_usuarios ");
        $this->ResultadoPg = $paginacao->getResultado();
               
        $listarUsuario = new \App\adms\Models\helper\AdmsRead();
        $listarUsuario->fullRead("SELECT user.id, user.nome, user.email,
                sit.nome nome_sit,
                cr.cor cor_cr
                FROM adms_usuarios user 
                INNER JOIN adms_sits_usuarios sit ON sit.id=user.adms_sits_usuario_id
                INNER JOIN adms_cors cr ON cr.id=sit.adms_cor_id
                ORDER BY id DESC LIMIT :limit OFFSET :offset", "limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarUsuario->getResultado();
        return $this->Resultado;
    }

}
