<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AdmsEditarNivAcPgMenu
{

    private $Resultado;
    private $Dados;
    private $DadosId;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function verNivAcPg($DadosId)
    {
        $this->DadosId = (int) $DadosId;
        $verNivAcPg = new \App\adms\Models\helper\AdmsRead();
        $verNivAcPg->fullRead("SELECT * FROM adms_nivacs_pgs
                WHERE id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verNivAcPg->getResultado();
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
        $upAltNivAc->exeUpdate("adms_nivacs_pgs", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);
        if ($upAltNivAc->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Item de menu da página atualizado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O item de menu da página não foi atualizado!</div>";
            $this->Resultado = false;
        }
    }
    
    /**
     * <b>Listar registros para chave estrangeira:</b> Buscar informações na tabela "adms_menus" para utilizar como chave estrangeira
     */
    public function listarCadastrar()
    {
        $listar = new \App\adms\Models\helper\AdmsRead();

        $listar->fullRead("SELECT id id_menu, nome nome_menu FROM adms_menus ORDER BY nome ASC");
        $registro['menu'] = $listar->getResultado();

        $this->Resultado = ['menu' => $registro['menu']];

        return $this->Resultado;
    }

}
