<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AdmsEditarGrupoPg
{

    private $Resultado;
    private $Dados;
    private $DadosId;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function verGrupoPg($DadosId)
    {
        $this->DadosId = (int) $DadosId;
        $verGrupoPg = new \App\adms\Models\helper\AdmsRead();
        $verGrupoPg->fullRead("SELECT * FROM adms_grps_pgs
                WHERE id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verGrupoPg->getResultado();
        return $this->Resultado;
    }

    public function altGrupoPg(array $Dados)
    {
        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->updateEditGrupoPg();
        } else {
            $this->Resultado = false;
        }
    }

    private function updateEditGrupoPg()
    {
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAltGrupoPg = new \App\adms\Models\helper\AdmsUpdate();
        $upAltGrupoPg->exeUpdate("adms_grps_pgs", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);
        if ($upAltGrupoPg->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Grupo de página atualizado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Grupo de página não foi atualizado!</div>";
            $this->Resultado = false;
        }
    }
    

}
