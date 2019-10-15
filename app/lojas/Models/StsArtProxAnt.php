<?php

namespace Sts\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sts\Models;

/**
 * Description of StsArtProxAnt
 *
 * @author Celke
 */
class StsArtProxAnt
{

    private $Resultado;
    private $IdArtigo;

    public function artigoProximo($IdArtigo = null)
    {
        $this->IdArtigo = (int) $IdArtigo;
        $listar = new \Sts\Models\helper\StsRead();
        $listar->fullRead('SELECT slug FROM sts_artigos 
                WHERE adms_sit_id =:adms_sit_id AND id >:id
                ORDER BY id ASC 
                LIMIT :limit', "adms_sit_id=1&id={$this->IdArtigo}&limit=1");

        $this->Resultado = $listar->getResultado();
        return $this->Resultado;
    }

    public function artigoAnterior($IdArtigo = null)
    {
        $this->IdArtigo = (int) $IdArtigo;
        $listar = new \Sts\Models\helper\StsRead();
        $listar->fullRead('SELECT slug FROM sts_artigos 
                WHERE adms_sit_id =:adms_sit_id AND id <:id
                ORDER BY id DESC 
                LIMIT :limit', "adms_sit_id=1&id={$this->IdArtigo}&limit=1");

        $this->Resultado = $listar->getResultado();
        return $this->Resultado;
    }

}
