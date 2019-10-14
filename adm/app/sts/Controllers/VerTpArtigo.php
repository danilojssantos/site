<?php

namespace App\sts\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class VerTpArtigo
{

    private $Dados;
    private $DadosId;

    public function verTpArtigo($DadosId = null)
    {

        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $verTpArtigo = new \App\sts\Models\StsVerTpArtigo();
            $this->Dados['dados_TpArtigo'] = $verTpArtigo->verTpArtigo($this->DadosId);

            $botao = ['list_tp_artigo' => ['menu_controller' => 'tp-artigo', 'menu_metodo' => 'listar'],
                'edit_tp_artigo' => ['menu_controller' => 'editar-tp-artigo', 'menu_metodo' => 'edit-tp-artigo'],
                'del_tp_artigo' => ['menu_controller' => 'apagar-tp-artigo', 'menu_metodo' => 'apagar-tp-artigo']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("sts/Views/tpArtigo/verTpArtigo", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Tipo de artigo não encontrado!</div>";
            $UrlDestino = URLADM . 'tp-artigo/listar';
            header("Location: $UrlDestino");
        }
    }

}
