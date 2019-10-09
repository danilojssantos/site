<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AdmsCadastrarMenu
{

    private $Resultado;
    private $Dados;
    private $UltimoMenu;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function cadMenu(array $Dados)
    {
        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->inserirMenu();
        } else {
            $this->Resultado = false;
        }
    }

    private function inserirMenu()
    {
        $this->Dados['created'] = date("Y-m-d H:i:s");
        $this->verUltimoMenu();
        $this->Dados['ordem'] = $this->UltimoMenu[0]['ordem'] + 1;
        $cadNivAc = new \App\adms\Models\helper\AdmsCreate;
        $cadNivAc->exeCreate("adms_menus", $this->Dados);
        if ($cadNivAc->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Item de menu cadastrado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O item de menu não foi cadastrado!</div>";
            $this->Resultado = false;
        }
    }
    
    private function verUltimoMenu()
    {
        $verMenu = new \App\adms\Models\helper\AdmsRead();
        $verMenu->fullRead("SELECT ordem FROM adms_menus ORDER BY ordem DESC LIMIT :limit", "limit=1");
        $this->UltimoMenu = $verMenu->getResultado();
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
