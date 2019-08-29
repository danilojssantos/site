<?php
namespace Sts\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class StsArtProxAnt 
{
    private $Resultado;
    private $IdArtigo;

    public function artigoProximo($IdArtigo = null)
    {
        $this->IdArtigo = (int) $IdArtigo;
        // echo "<br><br><br>{$this->IdArtigo}";

        $listar = new \Sts\Models\helper\StsRead();
        $listar->fullRead('SELECT slug FROM sts_artigos 
                WHERE adms_sit_id =:adms_sit_id AND id >:id
                ORDER BY id ASC 
                LIMIT :limit', "adms_sit_id=1&id={$this->IdArtigo}&limit=1");
        $this->Resultado = $listar->getResultado();
       // var_dump( $this->Resultado);
        return $this->Resultado;        
    }

    public function artigoAnterior($IdArtigo = null)
    {
        $this->IdArttigo = (int) $IdArtigo;
        $listar = new \Sts\Models\helper\StsRead();
        $listar->fullRead('SELECT slug FROM sts_artigos 
        WHERE adms_sit_id =:adms_sit_id AND id <:id
        ORDER BY id DESC 
        LIMIT :limit', "adms_sit_id=1&id={$this->IdArtigo}&limit=1");

        $this->Resultado = $listar->getResultado();
        return $this->Resultado;

    }
}

