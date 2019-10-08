<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AdmsAltOrdemNivAc
{

    private $DadosId;
    private $Resultado;
    private $Dados;
    private $DadosNivAc;
    private $DadosNivAvInferior;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function altOrdemNivAc($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        $this->verNivAc($this->DadosId);
        if ($this->DadosNivAc) {
            $this->verfNivAcInferior();
            $this->exeAltOrdemNivAc();
        }
    }

    private function verNivAc($DadosId)
    {
        $this->DadosId = (int) $DadosId;
        $verNivAc = new \App\adms\Models\helper\AdmsRead();
        $verNivAc->fullRead("SELECT * FROM adms_niveis_acessos
                WHERE id =:id AND ordem >:ordem LIMIT :limit", "id=" . $this->DadosId . "&ordem=" . $_SESSION['ordem_nivac'] . "&limit=1");
        $this->DadosNivAc = $verNivAc->getResultado();
    }

    private function verfNivAcInferior()
    {
        $ordem_super = $this->DadosNivAc[0]['ordem'] - 1;
        $verNivAc = new \App\adms\Models\helper\AdmsRead();
        $verNivAc->fullRead("SELECT id, ordem FROM adms_niveis_acessos WHERE ordem =:ordem", "ordem={$ordem_super}");
        $this->DadosNivAvInferior = $verNivAc->getResultado();
    }

    private function exeAltOrdemNivAc()
    {
        $this->Dados['ordem'] = $this->DadosNivAc[0]['ordem'];
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upMvBaixo = new \App\adms\Models\helper\AdmsUpdate();
        $upMvBaixo->exeUpdate("adms_niveis_acessos", $this->Dados, "WHERE id =:id", "id={$this->DadosNivAvInferior[0]['id']}");

        $this->Dados['ordem'] = $this->DadosNivAc[0]['ordem'] - 1;
        $upMvCima = new \App\adms\Models\helper\AdmsUpdate();
        $upMvCima->exeUpdate("adms_niveis_acessos", $this->Dados, "WHERE id =:id", "id={$this->DadosNivAc[0]['id']}");

        if ($upMvCima->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Ordem do nível de acesso editado com sucesso!</div>";
                $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Não foi alterado a ordem do nível de acesso!</div>";
                $this->Resultado = false;
        }
    }

}
