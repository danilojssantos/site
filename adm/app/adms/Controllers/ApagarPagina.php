<?php

namespace App\adms\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class ApagarPagina
{

    private $DadosId;

    public function apagarPagina($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
           $apagarPagina = new \App\adms\Models\AdmsApagarPagina();
           $apagarPagina->apagarPagina($this->DadosId);
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Necessário selecionar uma página!</div>";
        }
        $UrlDestino = URLADM . 'pagina/listar';
        header("Location: $UrlDestino");
    }

}
