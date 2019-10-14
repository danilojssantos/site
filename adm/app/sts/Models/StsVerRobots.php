<?php

namespace App\sts\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class StsVerRobots
{
    private $Resultado;
    private $DadosId;
    
    public function verRobots($DadosId)
    {
        $this->DadosId = (int) $DadosId;
        $verRobots = new \App\adms\Models\helper\AdmsRead();
        $verRobots->fullRead("SELECT * FROM sts_robots 
                WHERE id =:id LIMIT :limit", "id=".$this->DadosId."&limit=1");
        $this->Resultado= $verRobots->getResultado();
        return $this->Resultado;
    }
}
