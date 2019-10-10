<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AdmsApagarMenu
{

    private $DadosId;
    private $Resultado;
    private $Dados;
    private $DadosMenuInferior;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function apagarMenu($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        $this->verfPgCad();
        if ($this->Resultado) {
            $this->verfMenuInferior();
            $apagarMenu = new \App\adms\Models\helper\AdmsDelete();
            $apagarMenu->exeDelete("adms_menus", "WHERE id =:id", "id={$this->DadosId}");
            if ($apagarMenu->getResultado()) {
                $this->atualizarOrdem();
                $_SESSION['msg'] = "<div class='alert alert-success'>Item de menu apagado com sucesso!</div>";
                $this->Resultado = true;
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Item de menu não foi apagado!</div>";
                $this->Resultado = false;
            }
        }
    }

    private function verfPgCad()
    {
        $verMenu = new \App\adms\Models\helper\AdmsRead();
        $verMenu->fullRead("SELECT id FROM adms_nivacs_pgs
                WHERE adms_menu_id =:adms_menu_id LIMIT :limit", "adms_menu_id=" . $this->DadosId . "&limit=2");
        if ($verMenu->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O item de menu não pode ser apagado, há permissões cadastradas neste item de menu!</div>";
            $this->Resultado = false;
        } else {
            $this->Resultado = true;
        }
    }

    private function verfMenuInferior()
    {
        $verMenu = new \App\adms\Models\helper\AdmsRead();
        $verMenu->fullRead("SELECT id, ordem AS ordem_result FROM adms_menus WHERE ordem > (SELECT ordem FROM adms_menus WHERE id =:id) ORDER BY ordem ASC", "id={$this->DadosId}");
        $this->DadosMenuInferior = $verMenu->getResultado();
    }

    private function atualizarOrdem()
    {
        if ($this->DadosMenuInferior) {
            foreach ($this->DadosMenuInferior as $atualOrdem) {
                extract($atualOrdem);
                $this->Dados['ordem'] = $ordem_result - 1;
                $this->Dados['modified'] = date("Y-m-d H:i:s");
                $upAltMenu = new \App\adms\Models\helper\AdmsUpdate();
                $upAltMenu->exeUpdate("adms_menus", $this->Dados, "WHERE id =:id", "id=" . $id);
            }
        }
    }   

}
