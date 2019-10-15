<?php

namespace Sts\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sts\Models;

/**
 * Description of StsComentarios
 *
 * @author Celke
 */
class StsComentarios
{

    private $Resultado;
    private $IdArtigo;
    private $Dados;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function listComentario($IdArtigo = null)
    {
        $this->IdArtigo = (string) $IdArtigo;
        $listar = new \Sts\Models\helper\StsRead();
        $listar->fullRead('SELECT comt.id, comt.conteudo,
                user.id id_user, user.apelido, user.imagem imagem_user
                FROM sts_comts_artigos comt
                INNER JOIN adms_usuarios user ON user.id=comt.adms_usuario_id
                WHERE comt.sts_artigo_id =:sts_artigo_id AND
                (comt.adms_sit_id =:adms_sit_ida OR comt.adms_sit_id =:adms_sit_idb)           
                ORDER BY comt.id DESC', "sts_artigo_id={$this->IdArtigo}&adms_sit_ida=1&adms_sit_idb=3");
        $this->Resultado = $listar->getResultado();
        return $this->Resultado;
    }

    public function cadComentario(array $Dados)
    {
        $this->Dados = $Dados;
        $this->validarDados();
        if ($this->Resultado) {
            $this->verUsuario();
            if ($this->Resultado) {
                unset($this->Dados['nome'], $this->Dados['apelido'], $this->Dados['email'], $this->Dados['slug']);  
                $this->Dados['adms_sit_id'] = 3;
                $this->Dados['created'] = date("Y-m-d H:i:s");
                //var_dump($this->Dados);
                $this->inserir();
            }
        }
    }

    private function validarDados()
    {
        $this->Dados = array_map('strip_tags', $this->Dados);
        $this->Dados = array_map('trim', $this->Dados);
        if (in_array('', $this->Dados)) {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Para enviar o comentário preencha todos os campos!</div>";
            $this->Resultado = false;
        } else {
            if (filter_var($this->Dados['email'], FILTER_VALIDATE_EMAIL)) {
                $this->Resultado = true;
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: E-mail inválido!</div>";
                $this->Resultado = false;
            }
        }
    }

    private function inserir()
    {
        $cadComent = new \Sts\Models\helper\StsCreate();
        $cadComent->exeCreate('sts_comts_artigos', $this->Dados);
        if ($cadComent->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Comentário cadastrado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Comentário não foi cadastrado!</div>";
            $this->Resultado = false;
        }
    }

    private function verUsuario()
    {
        $verUsuario = new \Sts\Models\helper\StsRead();
        $verUsuario->fullRead("SELECT id FROM adms_usuarios
                WHERE email =:email LIMIT :limit ", "email={$this->Dados['email']}&limit=1");
        $this->UserId = $verUsuario->getResultado();
        if ($this->UserId) {
            $this->Dados['adms_usuario_id'] = $this->UserId[0]['id'];
            $this->Resultado = true;
        } else {
            $this->inserirUsuario();
        }
    }

    private function inserirUsuario()
    {
        $this->DadosUser['nome'] = $this->Dados['nome'];
        $this->DadosUser['apelido'] = $this->Dados['apelido'];
        $this->DadosUser['email'] = $this->Dados['email'];
        $this->DadosUser['usuario'] = $this->Dados['email'];
        $this->DadosUser['senha'] = password_hash(password_hash(date("Y-m-d H:i:s"), PASSWORD_DEFAULT), PASSWORD_DEFAULT);
        $this->DadosUser['adms_niveis_acesso_id'] = 5;
        $this->DadosUser['adms_sits_usuario_id'] = 3;
        $this->DadosUser['created'] = date("Y-m-d H:i:s");

        $cadUsuario = new \Sts\Models\helper\StsCreate();
        $cadUsuario->exeCreate("adms_usuarios", $this->DadosUser);
        if ($cadUsuario->getResultado()) {
            $this->Dados['adms_usuario_id'] = $cadUsuario->getResultado();
            $this->Resultado = $cadUsuario->getResultado();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O usuario não foi cadastrado!</div>";
            $this->Resultado = false;
        }
    }

}
