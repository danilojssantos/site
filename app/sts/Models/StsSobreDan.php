<?php

namespace Sts\Models;

if (!defined('URL')) {
    header('Location: /');
    exit();
}


class StsSobreDan
{
    private $Resultado;

    public function listarSobDan()
    {
        $listar = new \Sts\Models\helper\StsRead();
        $listar->FullRead('SELECT id, titulo, descricao, imagem FROM sts_sobs_emps WHERE adms_sit_id =:adms_sit_id ORDER BY ordem ASC', 'adms_sit_id=1');
       
        $this->Resultado['sts_sobs_emps'] = $listar->getResultado();
        return $this->Resultado['sts_sobs_emps'];
    }
}