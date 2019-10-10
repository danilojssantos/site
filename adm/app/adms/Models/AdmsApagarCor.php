<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AdmsApagarCor {

    private $DadosId;
    private $Resultado;

    function getResultado() {
        return $this->Resultado;
    }

    public function apagarCor($DadosId = null) {
        $this->DadosId = (int) $DadosId;
        $apagarCor = new \App\adms\Models\helper\AdmsDelete();
        $apagarCor->exeDelete("adms_cors", "WHERE id =:id", "id={$this->DadosId}");
        if ($apagarCor->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Cor apagada com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: A cor não foi apagada!</div>";
            $this->Resultado = false;
        }
    }

}
