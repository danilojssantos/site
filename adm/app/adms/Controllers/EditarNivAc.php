<?php

namespace App\adms\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class EditarNivAc
{

    private $Dados;
    private $DadosId;

    public function editNivAc($DadosId = null)
    {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $this->editNivAcPriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Nível de acesso não encontrado!</div>";
            $UrlDestino = URLADM . 'nivel-acesso/listar';
            header("Location: $UrlDestino");
        }
    }

    private function editNivAcPriv()
    {
        if (!empty($this->Dados['EditNivAc'])) {
            unset($this->Dados['EditNivAc']);
            $editarNivAc = new \App\adms\Models\AdmsEditarNivAc();
            $editarNivAc->altNivAc($this->Dados);
            if ($editarNivAc->getResultado()) {
                $_SESSION['msg'] = "<div class='alert alert-success'>Nível de acesso editado com sucesso!</div>";
                $UrlDestino = URLADM . 'ver-niv-ac/ver-niv-ac/' . $this->Dados['id'];
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editNivAcViewPriv();
            }
        } else {
            $verNivAc = new \App\adms\Models\AdmsEditarNivAc();
            $this->Dados['form'] = $verNivAc->verNivAc($this->DadosId);
            $this->editNivAcViewPriv();
        }
    }

    private function editNivAcViewPriv()
    {
        if ($this->Dados['form']) {            
            $botao = ['vis_nivac' => ['menu_controller' => 'ver-niv-ac', 'menu_metodo' => 'ver-niv-ac']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            $carregarView = new \Core\ConfigView("adms/Views/nivAcesso/editarNivAc", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Nível de acesso não encontrado!</div>";
            $UrlDestino = URLADM . 'nivel-acesso/listar';
            header("Location: $UrlDestino");
        }
    }

}
