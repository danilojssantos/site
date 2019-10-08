<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AdmsApagarPagina
{

    private $DadosId;
    private $Resultado;
    private $DadosUpNivAcPg;
    private $DadosNivAcPg;
    private $DadosNivAc;

    /**
     * <b>Obter Resultado:</b> Retorna TRUE caso tenha apagado com sucesso e FALSE quando não conseguiu editar
     * @return bool true ou false
     */
    function getResultado()
    {
        return $this->Resultado;
    }

    /**
     * <b>Ver Página:</b> Receber o id da página para apagar o registro no banco de dados
     * Chamar o método "pesqNivAc" para verificar a permissões com número da ordem maior da qual será apagada
     * @param int $DadosId
     */
    public function apagarPagina($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        $this->pesqNivAc();
        $apagarPagina = new \App\adms\Models\helper\AdmsDelete();
        $apagarPagina->exeDelete("adms_paginas", "WHERE id =:id", "id={$this->DadosId}");
        if ($apagarPagina->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Pagina apagada com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Pagina não foi apagada!</div>";
            $this->Resultado = false;
        }
    }

    /**
     * <b>Pesquisar Nível de Acesso:</b> Pesquisar no banco de dados os níveis de acesso
     * @return array $this->DadosNivAc
     */
    private function pesqNivAc()
    {
        $verNivAc = new \App\adms\Models\helper\AdmsRead();
        $verNivAc->fullRead("SELECT id id_nivac FROM adms_niveis_acessos ORDER BY id ASC");
        $this->DadosNivAc = $verNivAc->getResultado();
        $this->pesqNivAcPg();
    }

    /**
     * <b>Pesquisar as Permissões:</b> Pesquisar no banco de dados as permissões dos níveis de acesso na tabela "adms_nivacs_pgs"
     * @return array $this->DadosNivAcPg
     */
    private function pesqNivAcPg()
    {
        if ($this->DadosNivAc) {
            foreach ($this->DadosNivAc as $nivAc) {
                extract($nivAc);
                $verNivAcPg = new \App\adms\Models\helper\AdmsRead();
                $verNivAcPg->fullRead("SELECT id id_nivacpg, ordem FROM adms_nivacs_pgs
                        WHERE adms_niveis_acesso_id =:Aadms_niveis_acesso_id AND 
                        ordem > (SELECT ordem FROM adms_nivacs_pgs WHERE adms_pagina_id =:adms_pagina_id AND adms_niveis_acesso_id =:Badms_niveis_acesso_id) 
                        ORDER BY id ASC", "Aadms_niveis_acesso_id={$id_nivac}&adms_pagina_id={$this->DadosId}&Badms_niveis_acesso_id={$id_nivac}");
                $this->DadosNivAcPg = $verNivAcPg->getResultado();
                $this->updateOrdemNivAcPg();
                $apagarNivAcPg = new \App\adms\Models\helper\AdmsDelete();
                $apagarNivAcPg->exeDelete("adms_nivacs_pgs", "WHERE adms_pagina_id =:adms_pagina_id AND adms_niveis_acesso_id =:adms_niveis_acesso_id", "adms_pagina_id={$this->DadosId}&adms_niveis_acesso_id=$id_nivac");
            }
        }
    }

    /**
     * <b>Alterar Ordem NivAcPg:</b> Alterar as ordem maiores para o nível de acesso na tabela "adms_nivacs_pgs"
     * 
     */
    private function updateOrdemNivAcPg()
    {
        if ($this->DadosNivAcPg) {
            foreach ($this->DadosNivAcPg as $nivAcPg) {
                extract($nivAcPg);
                $this->DadosUpNivAcPg['ordem'] = $ordem - 1;
                $this->DadosUpNivAcPg['modified'] = date("Y-m-d H:i:s");
                $upAltNivAc = new \App\adms\Models\helper\AdmsUpdate();
                $upAltNivAc->exeUpdate("adms_nivacs_pgs", $this->DadosUpNivAcPg, "WHERE id =:id", "id=" . $id_nivacpg);
            }
        }
    }

}
