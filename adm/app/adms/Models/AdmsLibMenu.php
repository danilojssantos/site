<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsLibMenu
 *
 * @copyright (c) year, Cesar Szpak - Celke
 */
class AdmsLibMenu
{

    private $DadosId;
    private $Resultado;
    private $Dados;
    private $DadosNivAcPg;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function libMenu($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        $this->verNivAcPg();
        if ($this->DadosNivAcPg) {
            $this->altPermi();
        }else{
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Não foi alterado a situação do menu!</div>";
            $this->Resultado = false;
        }
    }

    private function verNivAcPg()
    {
        $verNivAcPg = new \App\adms\Models\helper\AdmsRead();
        $verNivAcPg->fullRead("SELECT nivpg.id, nivpg.lib_menu 
                FROM adms_nivacs_pgs nivpg
                INNER JOIN adms_niveis_acessos nivac ON nivac.id=nivpg.adms_niveis_acesso_id
                WHERE nivpg.id =:id AND nivac.ordem >=:ordem", "id={$this->DadosId}&ordem=".$_SESSION['ordem_nivac']);        
        $this->DadosNivAcPg = $verNivAcPg->getResultado();
    }

    private function altPermi()
    {
        if ($this->DadosNivAcPg[0]['lib_menu'] == 1) {
            $this->Dados['lib_menu'] = 2;
        } else {
            $this->Dados['lib_menu'] = 1;
        }
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upPerm = new \App\adms\Models\helper\AdmsUpdate();
        $upPerm->exeUpdate("adms_nivacs_pgs", $this->Dados, "WHERE id =:id", "id={$this->DadosId}");

        if ($upPerm->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Alterado a situação do menu com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Não foi alterado a situação do menu!</div>";
            $this->Resultado = false;
        }
    }

}
