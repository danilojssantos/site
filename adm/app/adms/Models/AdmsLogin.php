<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AdmsLogin
{

    private $Dados;
    private $Resultado;
    private $InfoCadUser;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function acesso(array $Dados)
    {
        $this->Dados = $Dados;        
        $this->validarDados();
        if ($this->Resultado) {
            $validaLogin = new \App\adms\Models\helper\AdmsRead();
            $validaLogin->fullRead("SELECT user.id, user.nome, user.email, user.senha, user.imagem, user.adms_niveis_acesso_id,
                    nivac.ordem	ordem_nivac
                    FROM adms_usuarios user
                    INNER JOIN adms_niveis_acessos nivac ON nivac.id=user.adms_niveis_acesso_id
                    WHERE usuario =:usuario LIMIT :limit", "usuario={$this->Dados['usuario']}&limit=1");
            $this->Resultado = $validaLogin->getResultado();
            if (!empty($this->Resultado)) {
                $this->validarSenha();
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Usuário não encontrado!</div>";
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

    private function validarSenha()
    {
        if (password_verify($this->Dados['senha'], $this->Resultado[0]['senha'])) {
            $_SESSION['usuario_id'] = $this->Resultado[0]['id'];
            $_SESSION['usuario_nome'] = $this->Resultado[0]['nome'];
            $_SESSION['usuario_email'] = $this->Resultado[0]['email'];
            $_SESSION['usuario_imagem'] = $this->Resultado[0]['imagem'];
            $_SESSION['adms_niveis_acesso_id'] = $this->Resultado[0]['adms_niveis_acesso_id'];
            $_SESSION['ordem_nivac'] = $this->Resultado[0]['ordem_nivac'];
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Usuário ou a senha incorreto!</div>";
            $this->Resultado = false;
        }
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

           
            if (($valSenha->getResultado()) AND ($valUsuario->getResultado()) AND($valEmailUnico->getResultado()) AND ( $valEmail->getResultado())) {
                
                $this->inserir();
            } else {
                $this->Resultado = false;
            }
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
        if($cadUser->getResultado()){
            $_SESSION['msg'] = "<div class='alert alert-success'>Usuário cadastrado com sucesso!</div>";
            $this->Resultado = true;
        }else{
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

}
