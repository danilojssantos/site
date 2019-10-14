<?php

namespace App\sts\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class VerContato
{

    private $Dados;
    private $DadosId;

    public function verContato($DadosId = null)
    {

        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $verContato = new \App\sts\Models\StsVerContato();
            $this->Dados['dados_Contato'] = $verContato->verContato($this->DadosId);

            $botao = ['list_contato' => ['menu_controller' => 'contato', 'menu_metodo' => 'listar'],
                'del_contato' => ['menu_controller' => 'apagar-contato', 'menu_metodo' => 'apagar-contato']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("sts/Views/contato/verContato", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Mensagem de contato não encontrado!</div>";
            $UrlDestino = URLADM . 'contato/listar';
            header("Location: $UrlDestino");
        }
    }

}
