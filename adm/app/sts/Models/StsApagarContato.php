<?php

namespace App\sts\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class StsApagarContato {

    private $DadosId;
    private $Resultado;

    function getResultado() {
        return $this->Resultado;
    }

    public function apagarContato($DadosId = null) {
        $this->DadosId = (int) $DadosId;
        $apagarContato = new \App\adms\Models\helper\AdmsDelete();
        $apagarContato->exeDelete("sts_contatos", "WHERE id =:id", "id={$this->DadosId}");
        if ($apagarContato->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Mensagem de contato apagado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Mensagem de contato não foi apagado!</div>";
            $this->Resultado = false;
        }
    }

}
