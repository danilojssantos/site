<?php

namespace App\sts\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class StsApagarSobEmpresa
{

    private $DadosId;
    private $Resultado;
    private $DadosSobEmpresa;
    private $DadosSobEmpresaInferior;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function apagarSobEmpresa($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        $this->verSobEmpresa();
        if ($this->DadosSobEmpresa) {
            $this->verfSobEmpresaInferior();
            $apagarSobEmpresa = new \App\adms\Models\helper\AdmsDelete();
            $apagarSobEmpresa->exeDelete("sts_sobs_emps", "WHERE id =:id", "id={$this->DadosId}");
            if ($apagarSobEmpresa->getResultado()) {
                $this->atualizarOrdem();
                $apagarImg = new \App\adms\Models\helper\AdmsApagarImg();
                $apagarImg->apagarImg('../assets/imagens/sob_emp/' . $this->DadosId . '/' . $this->DadosSobEmpresa[0]['imagem'], '../assets/imagens/sob_emp/' . $this->DadosId);
                $_SESSION['msg'] = "<div class='alert alert-success'>Tópico sobre empresa apagado com sucesso!</div>";
                $this->Resultado = true;
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Tópico sobre empresa não foi apagado!</div>";
                $this->Resultado = false;
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Tópico sobre empresa não foi apagado!</div>";
            $this->Resultado = false;
        }
    }

    public function verSobEmpresa()
    {
        $verSobEmpresa = new \App\adms\Models\helper\AdmsRead();
        $verSobEmpresa->fullRead("SELECT imagem FROM sts_sobs_emps WHERE id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->DadosSobEmpresa = $verSobEmpresa->getResultado();
    }

    private function verfSobEmpresaInferior()
    {
        $verSobEmpresa = new \App\adms\Models\helper\AdmsRead();
        $verSobEmpresa->fullRead("SELECT id, ordem AS ordem_result FROM sts_sobs_emps WHERE ordem > (SELECT ordem FROM sts_sobs_emps WHERE id =:id) ORDER BY ordem ASC", "id={$this->DadosId}");
        $this->DadosSobEmpresaInferior = $verSobEmpresa->getResultado();
    }

    private function atualizarOrdem()
    {
        if ($this->DadosSobEmpresaInferior) {
            foreach ($this->DadosSobEmpresaInferior as $atualOrdem) {
                extract($atualOrdem);
                $this->Dados['ordem'] = $ordem_result - 1;
                $this->Dados['modified'] = date("Y-m-d H:i:s");
                $upAltSobEmpresa = new \App\adms\Models\helper\AdmsUpdate();
                $upAltSobEmpresa->exeUpdate("sts_sobs_emps", $this->Dados, "WHERE id =:id", "id=" . $id);
            }
        }
    }

}
