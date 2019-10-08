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
        $paginacao->paginacao("SELECT COUNT(nivpg.id) AS num_result 
                FROM adms_nivacs_pgs nivpg
                INNER JOIN adms_paginas pg ON pg.id=nivpg.adms_pagina_id
                INNER JOIN adms_niveis_acessos nivac ON nivac.id=nivpg.adms_niveis_acesso_id
                WHERE nivpg.adms_niveis_acesso_id =:adms_niveis_acesso_id 
		AND nivac.ordem >=:ordem
                AND (((SELECT permissao FROM adms_nivacs_pgs WHERE adms_pagina_id=nivpg.adms_pagina_id AND adms_niveis_acesso_id={$_SESSION['adms_niveis_acesso_id']}) = 1) OR (pg.lib_pub = 1))
                    
                ", "adms_niveis_acesso_id={$this->NivId}&ordem=".$_SESSION['ordem_nivac']);
        $this->ResultadoPg = $paginacao->getResultado();

        $listarUsuario = new \App\adms\Models\helper\AdmsRead();
        $listarUsuario->fullRead("SELECT nivpg.id, nivpg.permissao, nivpg.ordem, nivpg.dropdown, nivpg.lib_menu,
                pg.nome_pagina, pg.obs obs_pg
                FROM adms_nivacs_pgs nivpg 
                INNER JOIN adms_paginas pg ON pg.id=nivpg.adms_pagina_id
                INNER JOIN adms_niveis_acessos nivac ON nivac.id=nivpg.adms_niveis_acesso_id
                WHERE nivpg.adms_niveis_acesso_id =:adms_niveis_acesso_id AND nivac.ordem >=:ordem
                AND (((SELECT permissao FROM adms_nivacs_pgs WHERE adms_pagina_id=nivpg.adms_pagina_id AND adms_niveis_acesso_id={$_SESSION['adms_niveis_acesso_id']}) = 1) OR (pg.lib_pub = 1))
                ORDER BY nivpg.ordem ASC LIMIT :limit OFFSET :offset", "adms_niveis_acesso_id={$this->NivId}&ordem=".$_SESSION['ordem_nivac']."&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
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
