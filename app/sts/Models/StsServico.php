<?php
namespace Sts\Models;

if (!defined('URL')) {
header("Location: /");
exit();
}


class StsServico
{
    private $Resultado;

    public function listar()
    {
        $listar = new \Sts\Models\helper\StsRead();
        $listar->exeRead('sts_servicos','LIMIT :limit','limit=1');
        $this->Resultado = $listar->getResultado();
        return $this->Resultado;

    }

}