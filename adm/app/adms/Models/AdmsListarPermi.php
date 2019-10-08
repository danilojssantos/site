<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AdmsListarPermi
{

    private $Resultado;
    private $PageId;
    private $LimiteResultado = 10;
    private $ResultadoPg;
    private $NivId;

    function getResultadoPg()
    {
        return $this->ResultadoPg;
    }

    public function listarPermi($PageId = null, $NivId = null)
    {
        $this->PageId = (int) $PageId;
        $this->NivId = (int) $NivId;

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'permissoes/listar', "?niv=" . $this->NivId);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result 
                FROM adms_nivacs_pgs
                WHERE adms_niveis_acesso_id =:adms_niveis_acesso_id", "adms_niveis_acesso_id={$this->NivId}");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarUsuario = new \App\adms\Models\helper\AdmsRead();
        $listarUsuario->fullRead("SELECT nivpg.id, nivpg.permissao, nivpg.ordem, nivpg.dropdown, nivpg.lib_menu,
                pg.nome_pagina, pg.obs obs_pg
                FROM adms_nivacs_pgs nivpg 
                INNER JOIN adms_paginas pg ON pg.id=nivpg.adms_pagina_id
                WHERE adms_niveis_acesso_id =:adms_niveis_acesso_id
                ORDER BY nivpg.ordem ASC LIMIT :limit OFFSET :offset", "adms_niveis_acesso_id={$this->NivId}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarUsuario->getResultado();
        return $this->Resultado;
    }
    
    public function verNivAc($DadosId)
    {
        $this->DadosId = (int) $DadosId;
        $verNivAc = new \App\adms\Models\helper\AdmsRead();
        $verNivAc->fullRead("SELECT id, nome FROM adms_niveis_acessos 
                WHERE id =:id LIMIT :limit", "id=".$this->DadosId."&limit=1");
        $this->Resultado= $verNivAc->getResultado();
        return $this->Resultado;
    }

}
