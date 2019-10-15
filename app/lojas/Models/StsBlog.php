<?php

namespace Sts\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of StsBlog
 *
 * @copyright (c) year, Cesar Szpak - Celke
 */
class StsBlog
{

    private $Resultado;
    private $PageId;
    private $ResultadoPg;
    private $LimiteResultado = 2;

    function getResultadoPg()
    {
        return $this->ResultadoPg;
    }

    public function listarArtigos($PageId = null)
    {
        $this->PageId = (int) $PageId;
        $paginacao = new \Sts\Models\helper\StsPaginacao(URL . 'blog');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao('SELECT COUNT(id) AS num_result
                FROM sts_artigos
                WHERE adms_sit_id =:adms_sit_id', 'adms_sit_id=1');
        $this->ResultadoPg = $paginacao->getResultado();

        $listar = new \Sts\Models\helper\StsRead();
        $listar->fullRead('SELECT id, titulo, descricao, imagem, slug FROM sts_artigos 
                WHERE adms_sit_id =:adms_sit_id
                ORDER BY id DESC
                LIMIT :limit OFFSET :offset', "adms_sit_id=1&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listar->getResultado();
        return $this->Resultado;
    }

}
