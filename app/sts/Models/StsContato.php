<?php

namespace Sts\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class StsContato
{
    private $Resultado;
    private $Dados;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function cadContato(array $Dados)
    {
        $this->Dados = $Dados;
        $this->validarDados();
        if ($this->Resultado) {
            $this->inserir();
        }

       
    }


    private  function validarDados()
    {
        //limpar as tags 

        $this->Dados = array_map('strip_tags',$this->Dados);
        //limpar os espaços em branco 

        $this->Dados = array_map('trim',$this->Dados);

        //validação de campos vazio

        if (in_array('',$this->Dados)) {
            $_SESSION['msg'] ="<div class='alert alert-danger'>Para enviar a mensagem preencha todos os campos !</div>";
             $this->Resultado = false;
        }else{
            if (filter_var($this->Dados['email'], FILTER_VALIDATE_EMAIL)) {
                $this->Resultado = true;
            } else{
                $_SESSION['msg'] ="<div class='alert alert-danger'>Erro Email Invalido !</div>";
             $this->Resultado = false;
            }
          
        }


    }


    private function inserir()
    {
        $cadContato = new \Sts\Models\helper\StsCreate();
        $cadContato->exeCreate('sts_contatos', $this->Dados);
        
        if ($cadContato->getResultado()) {
            $_SESSION['msg'] ="<div class='alert alert-success'>Mensagem Enviada com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] ="<div class='alert alert-danger'>Mensagem não foi Enviada !</div>";
            $this->Resultado = false;
        }
    }

    

    
}
