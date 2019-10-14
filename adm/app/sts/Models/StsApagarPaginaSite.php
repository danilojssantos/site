<?php

namespace App\sts\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class StsApagarPaginaSite
{

    private $DadosId;
    private $Resultado;
    private $DadosPaginaSite;
    private $DadosPaginaSiteInferior;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function apagarPaginaSite($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        $this->verPaginaSite();
        if ($this->DadosPaginaSite) {
            $this->verfPaginaSiteInferior();
            $apagarPaginaSite = new \App\adms\Models\helper\AdmsDelete();
            $apagarPaginaSite->exeDelete("sts_paginas", "WHERE id =:id", "id={$this->DadosId}");
            if ($apagarPaginaSite->getResultado()) {
                $this->atualizarOrdem();
                $apagarImg = new \App\adms\Models\helper\AdmsApagarImg();
                $apagarImg->apagarImg('../assets/imagens/pagina/' . $this->DadosId . '/' . $this->DadosPaginaSite[0]['imagem'], '../assets/imagens/pagina/' . $this->DadosId);
                $_SESSION['msg'] = "<div class='alert alert-success'>Página do site apagado com sucesso!</div>";
                $this->Resultado = true;
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Página do site não foi apagado!</div>";
                $this->Resultado = false;
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Página do site não foi apagado!</div>";
            $this->Resultado = false;
        }
    }

    public function verPaginaSite()
    {
        $verPaginaSite = new \App\adms\Models\helper\AdmsRead();
        $verPaginaSite->fullRead("SELECT imagem FROM sts_paginas WHERE id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->DadosPaginaSite = $verPaginaSite->getResultado();
    }

    private function verfPaginaSiteInferior()
    {
        $verPaginaSite = new \App\adms\Models\helper\AdmsRead();
        $verPaginaSite->fullRead("SELECT id, ordem AS ordem_result FROM sts_paginas WHERE ordem > (SELECT ordem FROM sts_paginas WHERE id =:id) ORDER BY ordem ASC", "id={$this->DadosId}");
        $this->DadosPaginaSiteInferior = $verPaginaSite->getResultado();
    }

    private function atualizarOrdem()
    {
        if ($this->DadosPaginaSiteInferior) {
            foreach ($this->DadosPaginaSiteInferior as $atualOrdem) {
                extract($atualOrdem);
                $this->Dados['ordem'] = $ordem_result - 1;
                $this->Dados['modified'] = date("Y-m-d H:i:s");
                $upAltPaginaSite = new \App\adms\Models\helper\AdmsUpdate();
                $upAltPaginaSite->exeUpdate("sts_paginas", $this->Dados, "WHERE id =:id", "id=" . $id);
            }
        }
    }

}
