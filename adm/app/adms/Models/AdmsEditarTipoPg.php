<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AdmsEditarTipoPg
{

    private $Resultado;
    private $Dados;
    private $DadosId;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function verTipoPg($DadosId)
    {
        $this->DadosId = (int) $DadosId;
        $verTipoPg = new \App\adms\Models\helper\AdmsRead();
        $verTipoPg->fullRead("SELECT * FROM adms_tps_pgs
                WHERE id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verTipoPg->getResultado();
        return $this->Resultado;
    }

    public function altTipoPg(array $Dados)
    {
        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->updateEditTipoPg();
        } else {
            $this->Resultado = false;
        }
    }

    private function updateEditTipoPg()
    {
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAltTipoPg = new \App\adms\Models\helper\AdmsUpdate();
        $upAltTipoPg->exeUpdate("adms_tps_pgs", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);
        if ($upAltTipoPg->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Tipo de página atualizado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Tipo de página não foi atualizado!</div>";
            $this->Resultado = false;
        }
    }
    

}
