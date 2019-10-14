<?php

namespace App\sts\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class StsVerArtigo
{
    private $Resultado;
    private $DadosId;
    
    public function verArtigo($DadosId)
    {
        $this->DadosId = (int) $DadosId;
        $verArtigo = new \App\adms\Models\helper\AdmsRead();
        $verArtigo->fullRead("SELECT art.*,
                rob.nome nome_rob, rob.tipo tipo_rob,
                user.nome nome_user,
                sit.nome nome_sit,
                cr.cor cor_cr,
                tpart.nome nome_tpart,
                catart.nome nome_catart
                FROM sts_artigos art
                INNER JOIN sts_robots rob ON rob.id=art.sts_robot_id
                INNER JOIN adms_usuarios user ON user.id=art.adms_usuario_id
                INNER JOIN adms_sits sit ON sit.id=art.adms_sit_id
                INNER JOIN adms_cors cr ON cr.id=sit.adms_cor_id
                INNER JOIN sts_tps_artigos tpart ON tpart.id=art.sts_tps_artigo_id
                INNER JOIN sts_cats_artigos catart ON catart.id=art.sts_cats_artigo_id
                WHERE art.id =:id LIMIT :limit", "id=".$this->DadosId."&limit=1");
        $this->Resultado= $verArtigo->getResultado();
        return $this->Resultado;
    }
}
