<?php

namespace App\sts\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class StsVerPaginaSite
{
    private $Resultado;
    private $DadosId;
    
    /**
     * <b>Ver Página:</b> Receber o id da página para buscar informações do registro no banco de dados
     * @param int $DadosId
     */
    public function verPaginaSite($DadosId)
    {
        $this->DadosId = (int) $DadosId;
        $verPagina = new \App\adms\Models\helper\AdmsRead();
        $verPagina->fullRead("SELECT pg.*,
                tpgs.tipo tipo_tpgs, tpgs.nome nome_tpgs,
                rob.nome nome_rob, rob.tipo tipo_rob, 
                sitpg.nome nome_sitpg,
                cr.cor cor_cr
                FROM sts_paginas pg
                INNER JOIN sts_tps_pgs tpgs ON tpgs.id=pg.sts_tps_pg_id
                INNER JOIN sts_robots rob ON rob.id=pg.sts_robot_id
                INNER JOIN sts_situacaos_pgs sitpg ON sitpg.id=pg.sts_situacaos_pg_id
                INNER JOIN adms_cors cr ON cr.id=sitpg.adms_cor_id
                WHERE pg.id =:id LIMIT :limit", "id=".$this->DadosId."&limit=1");
        $this->Resultado= $verPagina->getResultado();
        return $this->Resultado;
    }
}
