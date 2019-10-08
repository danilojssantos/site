<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AdmsLibPermi
{

    private $DadosId;
    private $Resultado;
    private $Dados;
    private $DadosNivAcPg;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function libPermi($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        $this->verNivAcPg();
        if ($this->DadosNivAcPg) {
            $this->altPermi();
        }else{
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Não foi alterado a permissão de acesso a página!</div>";
            $this->Resultado = false;
        }
    }

    private function verNivAcPg()
    {
        $verNivAcPg = new \App\adms\Models\helper\AdmsRead();
        $verNivAcPg->fullRead("SELECT nivpg.id, nivpg.permissao 
                FROM adms_nivacs_pgs nivpg
                INNER JOIN adms_niveis_acessos nivac ON nivac.id=nivpg.adms_niveis_acesso_id
                WHERE nivpg.id =:id AND nivac.ordem >:ordem", "id={$this->DadosId}&ordem=".$_SESSION['ordem_nivac']);        
        $this->DadosNivAcPg = $verNivAcPg->getResultado();
    }

    private function altPermi()
    {
        if ($this->DadosNivAcPg[0]['permissao'] == 1) {
            $this->Dados['permissao'] = 2;
        } else {
            $this->Dados['permissao'] = 1;
        }
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upPerm = new \App\adms\Models\helper\AdmsUpdate();
        $upPerm->exeUpdate("adms_nivacs_pgs", $this->Dados, "WHERE id =:id", "id={$this->DadosId}");

        if ($upPerm->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Alterado a permissão de acesso a página com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Não foi alterado a permissão de acesso a página!</div>";
            $this->Resultado = false;
        }
    }

}
