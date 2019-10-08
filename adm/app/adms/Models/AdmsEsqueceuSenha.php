<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsEsqeceuSenha
 *
 * @copyright (c) year, Cesar Szpak - Celke
 */
class AdmsEsqueceuSenha
{

    private $Resultado;
    private $DadosUsuario;
    private $Dados;
    private $DadosEmail;
    private $DadosUpdate;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function esqueceuSenha(array $Dados)
    {
        $this->Dados = $Dados;
        $this->validarDados();
        if ($this->Resultado) {
            $esqSenha = new \App\adms\Models\helper\AdmsRead();
            $esqSenha->fullRead("SELECT id, nome, usuario, recuperar_senha FROM adms_usuarios WHERE email =:email LIMIT :limit", "email={$this->Dados['email']}&limit=1");
            $this->DadosUsuario = $esqSenha->getResultado();
            if (!empty($this->DadosUsuario)) {
                $this->valChaveRecSenha();
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: E-mail não cadastrado!</div>";
                $this->Resultado = false;
            }
        }
    }

    private function validarDados()
    {
        $this->Dados = array_map('strip_tags', $this->Dados);
        $this->Dados = array_map('trim', $this->Dados);
        if (in_array('', $this->Dados)) {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Necessário preencher todos os campos!</div>";
            $this->Resultado = false;
        } else {
            $valEmail = new \App\adms\Models\helper\AdmsEmail();
            $valEmail->valEmail($this->Dados['email']);
            if($valEmail->getResultado()){
                $this->Resultado = true;
            }else{
                $this->Resultado = false;
            }            
        }
    }

    private function valChaveRecSenha()
    {
        if (!empty($this->DadosUsuario[0]['recuperar_senha'])) {
            $this->dadosEmail();
        } else {
            $this->DadosUpdate['recuperar_senha'] = md5($this->DadosUsuario[0]['id'] . date('Y-m-d H:i:s'));
            $this->DadosUpdate['modified'] = date('Y-m-d H:i:s');

            $updateRecSenha = new \App\adms\Models\helper\AdmsUpdate();
            $updateRecSenha->exeUpdate("adms_usuarios", $this->DadosUpdate, "WHERE id =:id", "id={$this->DadosUsuario[0]['id']}");
            if ($updateRecSenha->getResultado()) {
                $this->DadosUsuario[0]['recuperar_senha'] = $this->DadosUpdate['recuperar_senha'];
                $this->dadosEmail();
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Erro ao recuperar a senha!</div>";
                $this->Resultado = false;
            }
        }
    }

    private function dadosEmail()
    {
        $nome = explode(" ", $this->DadosUsuario[0]['nome']);
        $prim_nome = $nome[0];
        $this->DadosEmail['dest_nome'] = $prim_nome;
        $this->DadosEmail['dest_email'] = $this->Dados['email'];
        $this->DadosEmail['titulo_email'] = "Recuperar senha";
        $this->DadosEmail['cont_email'] = "Olá " . $prim_nome . "<br><br>";
        $this->DadosEmail['cont_email'] .= "Você solicitou uma alteração de senha.<br>";
        $this->DadosEmail['cont_email'] .= "Seguindo o link abaixo você poderá alterar sua senha.<br>";
        $this->DadosEmail['cont_email'] .= "Para continuar o processo de recuperação de sua senha, clique no link abaixo ou cole o endereço abaixo no seu navegador.<br><br>";
        $this->DadosEmail['cont_email'] .= "<a href='" . URLADM . "atual-senha/atual-senha?chave=" . $this->DadosUsuario[0]['recuperar_senha'] . "'>Clique aqui</a><br><br>";
        $this->DadosEmail['cont_email'] .= "Usuário: " . $this->DadosUsuario[0]['usuario'] . "<br><br>";
        $this->DadosEmail['cont_email'] .= "Se você não solicitou essa alteração, nenhuma ação é necessária. Sua senha permanecerá a mesma até que você ative este código.<br><br>";


        $this->DadosEmail['cont_text_email'] = "Olá " . $prim_nome . " Você solicitou uma alteração de senha. Seguindo o link abaixo você poderá alterar sua senha. Para continuar o processo de recuperação de sua senha, clique no link abaixo ou cole o endereço abaixo no seu navegador. " . URLADM . "atual-senha/atual-senha?chave=" . $this->DadosUsuario[0]['recuperar_senha'] . " Usuário: " . $this->DadosUsuario[0]['usuario'] . "Se você não solicitou essa alteração, nenhuma ação é necessária. Sua senha permanecerá a mesma até que você ative este código.";

        $emailPHPMailer = new \App\adms\Models\helper\AdmsPhpMailer();
        $emailPHPMailer->emailPhpMailer($this->DadosEmail);

        if ($emailPHPMailer->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>E-mail enviado com sucesso, verifique sua caixa de entrada!</div>";
            $this->Resultado = true;
        } else {
            //$_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Erro ao recuperar a senha!</div>";
            $this->Resultado = false;
        }
    }

}
