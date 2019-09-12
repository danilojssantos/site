<?php

namespace App\adms\Controllers;

if (!defined ('URL')) {
    header("Location /");
    exit();
}

class Login 
{
    private $Dados;
    public function acesso()
    {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
       // var_dump($this->Dados);
        
        if (!empty($this->Dados['SendLogin'])) {
             unset($this->Dados['SendLogin']);
             $visualLogin = new \App\adms\Models\AdmsLogin();
             $visualLogin->acesso($this->Dados);

             if ($visualLogin->getResultado()) {
                 $UrlDestino = URLADM . 'home/index';
                 header("Location: $UrlDestino");
                 exit();
             }else{
                $this->Dados['form'] = $this->Dados;
             }
            
        }   

        $carregarView = new \Core\ConfigView("adms/Views/login/acesso",$this->Dados);

        $carregarView->renderizarLogin();
    }

        public function logout()
        {
            unset( $_SESSION['usuario_id'],
            $_SESSION['usuario_nome'],
            $_SESSION['usuario_email'],
            $_SESSION['usuario_imagem'],
            $_SESSION['adms_niveis_acesso_id'],
            $_SESSION['ordem_nivac']);
            $_SESSION['msg'] = "<div class='alert alert-success'>Deslogado com Sucesso</div>";
            $UrlDestino = URLADM . 'login/acesso';
            header("Location: $UrlDestino");
            exit();
        }

        public function novoUsuario()
        {
            $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            if (!empty($this->Dados['CadUserLogin'])) {
               unset($this->Dados['CadUserLogin']);
                //var_dump($this->Dados);
                
                $cadUser = new \App\adms\Models\AdmsLogin();
                $cadUser->cadUser($this->Dados);

                if ($cadUser->getResultado()) {
                    $UrlDestino = URLADM . 'login/acesso';
                    header("loccation: $UrlDestino");
                }else{
                    $this->Dados['form'] = $this->Dados;
                }
                
                
            }
            $carregarView = new \Core\ConfigView("adms/Views/login/novoUsuario",$this->Dados);

            $carregarView->renderizarLogin();
        }
}