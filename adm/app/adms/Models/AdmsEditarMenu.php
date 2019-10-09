<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AdmsEditarMenu
{

    private $Resultado;
    private $Dados;
    private $DadosId;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function verMenu($DadosId)
    {
        $this->DadosId = (int) $DadosId;
        $verMenu = new \App\adms\Models\helper\AdmsRead();
        $verMenu->fullRead("SELECT * FROM adms_menus
                WHERE id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verMenu->getResultado();
        return $this->Resultado;
    }

    public function altMenu(array $Dados)
    {
        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->updateEditMenu();
        } else {
            $this->Resultado = false;
        }
    }

    private function updateEditMenu()
    {
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAltNivAc = new \App\adms\Models\helper\AdmsUpdate();
        $upAltNivAc->exeUpdate("adms_menus", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);
        if ($upAltNivAc->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Item de menu atualizado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O item de menu não foi atualizado!</div>";
            $this->Resultado = false;
        }
    }
    
    /**
     * <b>Listar registros para chave estrangeira:</b> Buscar informações na tabela "adms_sits" para utilizar como chave estrangeira
     */
    public function listarCadastrar()
    {
        $listar = new \App\adms\Models\helper\AdmsRead();

        $listar->fullRead("SELECT id id_sit, nome nome_sit FROM adms_sits ORDER BY nome ASC");
        $registro['sit'] = $listar->getResultado();

        $this->Resultado = ['sit' => $registro['sit']];

        return $this->Resultado;
    }

}
