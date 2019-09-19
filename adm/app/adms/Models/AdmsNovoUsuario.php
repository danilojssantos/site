<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsLogin
 *
 * @copyright (c) year, Cesar Szpak - Celke
 */
class AdmsNovoUsuario
{

    private $Dados;
    private $Resultado;
    private $InfoCadUser;
    private $DadosEmail;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function cadUser(array $Dados)
    {
        $this->Dados = $Dados;
        $this->validarDados();
        if ($this->Resultado) {
            $valEmail = new \App\adms\Models\helper\AdmsEmail();
            $valEmail->valEmail($this->Dados['email']);

            $valEmailUnico = new \App\adms\Models\helper\AdmsEmailUnico();
            $valEmailUnico->valEmailUnico($this->Dados['email']);

            $valUsuario = new \App\adms\Models\helper\AdmsValUsuario();
            $valUsuario->valUsuario($this->Dados['usuario']);

            $valSenha = new \App\adms\Models\helper\AdmsValSenha();
            $valSenha->valSenha($this->Dados['senha']);

            if (($valSenha->getResultado()) AND ( $valUsuario->getResultado()) AND ( $valEmailUnico->getResultado()) AND ( $valEmail->getResultado())) {
                $this->inserir();
            } else {
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
            $this->Resultado = true;
        }
    }

    private function inserir()
    {
        $this->infoCadUser();
        $this->Dados['senha'] = password_hash($this->Dados['senha'], PASSWORD_DEFAULT);

        $this->Dados['conf_email'] = md5($this->Dados['senha'] . date('Y-m-d H:i'));
        $this->Dados['adms_niveis_acesso_id'] = $this->InfoCadUser[0]['adms_niveis_acesso_id'];
        $this->Dados['adms_sits_usuario_id'] = $this->InfoCadUser[0]['adms_sits_usuario_id'];
        $this->Dados['created'] = date('Y-m-d H:i:s');
        $cadUser = new \App\adms\Models\helper\AdmsCreate();
        $cadUser->exeCreate('adms_usuarios', $this->Dados);
        if ($cadUser->getResultado()) {
            $this->dadosEmail();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Usuário não foi cadastrado com sucesso!</div>";
            $this->Resultado = false;
        }
    }

    private function infoCadUser()
    {
        $infoCadUser = new \App\adms\Models\helper\AdmsRead();
        $infoCadUser->fullRead("SELECT env_email_conf, adms_niveis_acesso_id, adms_sits_usuario_id FROM adms_cads_usuarios WHERE id =:id LIMIT :limit", "id=1&limit=1");
        $this->InfoCadUser = $infoCadUser->getResultado();
    }

    private function dadosEmail()
    {
        $nome = explode(" ", $this->Dados['nome']);
        $prim_nome = $nome[0];
        $this->DadosEmail['dest_nome'] = $prim_nome;
        $this->DadosEmail['dest_email'] = $this->Dados['email'];
        $this->DadosEmail['titulo_email'] = "Confirmar e-mail";
        $this->DadosEmail['cont_email'] = "Caro(a) $prim_nome ,<br><br>";
        $this->DadosEmail['cont_email'] .= "Obrigado por se cadastrar conosco. Para ativar seu perfil, clique no link abaixo:<br><br>";
        $this->DadosEmail['cont_email'] .= "<a href='" . URLADM . "confirmar/confirmar_email?chave=" . $this->Dados['conf_email'] . "'>Clique aqui</a><br><br>";
        $this->DadosEmail['cont_email'] .= "Obrigado<br>";        
        
        $this->DadosEmail['cont_text_email'] = "Caro(a) $prim_nome ,";
        $this->DadosEmail['cont_text_email'] .= "Obrigado por se cadastrar conosco. Para ativar seu perfil, copie o endereço abaixo e cole no navegador:";
        $this->DadosEmail['cont_text_email'] .= URLADM . "confirmar/confirmar_email?chave=" . $this->Dados['conf_email'];
        $this->DadosEmail['cont_text_email'] .= "Obrigado";
        
        $emailPHPMailer = new \App\adms\Models\helper\AdmsPhpMailer();
        $emailPHPMailer->emailPhpMailer($this->DadosEmail);
        if($emailPHPMailer->getResultado()){
            $_SESSION['msg'] = "<div class='alert alert-success'>Usuário cadastrado com sucesso. Enviado no seu e-mail o link para confirmar o e-mail!</div>";
            $this->Resultado = true;            
        }else{
            $_SESSION['msg'] = "<div class='alert alert-primary'>Usuário cadastrado com sucesso. Erro: Não foi possivel enviar o link no seu e-mail para confirmar o e-mail!</div>";
            $this->Resultado = false; 
        }
    }

}
