<?php

namespace App\sts\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of StsEditarSitPgSite
 *
 * @copyright (c) year, Cesar Szpak - Celke
 */
class StsEditarSitPgSite
{

    private $Resultado;
    private $Dados;
    private $DadosId;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function verSitPgSite($DadosId)
    {
        $this->DadosId = (int) $DadosId;
        $verSitPgSite = new \App\adms\Models\helper\AdmsRead();
        $verSitPgSite->fullRead("SELECT * FROM sts_situacaos_pgs
                WHERE id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verSitPgSite->getResultado();
        return $this->Resultado;
    }

    public function altSitPgSite(array $Dados)
    {
        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->updateEditSitPgSite();
        } else {
            $this->Resultado = false;
        }
    }

    private function updateEditSitPgSite()
    {
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAltSitPgSite = new \App\adms\Models\helper\AdmsUpdate();
        $upAltSitPgSite->exeUpdate("sts_situacaos_pgs", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);
        if ($upAltSitPgSite->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Situação de página de site atualizado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Situação de página de site não foi atualizado!</div>";
            $this->Resultado = false;
        }
    }
    
    public function listarCadastrar()
    {
        $listar = new \App\adms\Models\helper\AdmsRead();
        
        $listar->fullRead("SELECT id id_cr, nome nome_cr FROM adms_cors ORDER BY nome ASC");
        $registro['cr'] = $listar->getResultado();

        $this->Resultado = ['cr' => $registro['cr']];

        return $this->Resultado;
    }
    
}
