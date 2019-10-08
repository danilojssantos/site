<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AdmsApagarNivAc
{

    private $DadosId;
    private $Resultado;
    private $Dados;
    private $DadosNivAvInferior;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function apagarNivAc($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        $this->verfUsuarioCad();
        if ($this->Resultado) {
            $this->verfNivAcInferior();
            $apagarNivAc = new \App\adms\Models\helper\AdmsDelete();
            $apagarNivAc->exeDelete("adms_niveis_acessos", "WHERE id =:id", "id={$this->DadosId}");
            if ($apagarNivAc->getResultado()) {
                $this->atualizarOrdem();
                $_SESSION['msg'] = "<div class='alert alert-success'>Nível de acesso apagado com sucesso!</div>";
                $this->Resultado = true;
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Nivel de acesso não foi apagado!</div>";
                $this->Resultado = false;
            }
        }
    }

    private function verfUsuarioCad()
    {
        $verUsuario = new \App\adms\Models\helper\AdmsRead();
        $verUsuario->fullRead("SELECT id FROM adms_usuarios
                WHERE adms_niveis_acesso_id =:adms_niveis_acesso_id LIMIT :limit", "adms_niveis_acesso_id=" . $this->DadosId . "&limit=2");
        if ($verUsuario->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O nível de acesso não pode ser apagado, há usuários cadastrados neste nível!</div>";
            $this->Resultado = false;
        } else {
            $this->Resultado = true;
        }
    }

    private function verfNivAcInferior()
    {
        $verNivAc = new \App\adms\Models\helper\AdmsRead();
        $verNivAc->fullRead("SELECT id, ordem AS ordem_result FROM adms_niveis_acessos WHERE ordem > (SELECT ordem FROM adms_niveis_acessos WHERE id =:id) ORDER BY ordem ASC", "id={$this->DadosId}");
        $this->DadosNivAvInferior = $verNivAc->getResultado();
    }

    private function atualizarOrdem()
    {
        if ($this->DadosNivAvInferior) {
            foreach ($this->DadosNivAvInferior as $atualOrdem) {
                extract($atualOrdem);
                $this->Dados['ordem'] = $ordem_result - 1;
                $this->Dados['modified'] = date("Y-m-d H:i:s");
                $upAltNivAc = new \App\adms\Models\helper\AdmsUpdate();
                $upAltNivAc->exeUpdate("adms_niveis_acessos", $this->Dados, "WHERE id =:id", "id=" . $id);
            }
        }
    }

}
