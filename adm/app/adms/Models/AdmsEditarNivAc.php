<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsEditarNivAc
 *
 * @copyright (c) year, Cesar Szpak - Celke
 */
class AdmsEditarNivAc
{

    private $Resultado;
    private $Dados;
    private $DadosId;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function verNivAc($DadosId)
    {
        $this->DadosId = (int) $DadosId;
        $verPerfil = new \App\adms\Models\helper\AdmsRead();
        $verPerfil->fullRead("SELECT * FROM adms_niveis_acessos
                WHERE id =:id AND ordem >=:ordem LIMIT :limit", "id=" . $this->DadosId . "&ordem=".$_SESSION['ordem_nivac']."&limit=1");
        $this->Resultado = $verPerfil->getResultado();
        return $this->Resultado;
    }

    public function altNivAc(array $Dados)
    {
        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->updateEditNivAc();
        } else {
            $this->Resultado = false;
        }
    }

    private function updateEditNivAc()
    {
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAltNivAc = new \App\adms\Models\helper\AdmsUpdate();
        $upAltNivAc->exeUpdate("adms_niveis_acessos", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);
        if ($upAltNivAc->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Nível de acesso atualizado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O nível de acesso não foi atualizado!</div>";
            $this->Resultado = false;
        }
    }

}
