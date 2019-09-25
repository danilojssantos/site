<?php

namespace App\adms\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AtualSenha 
{
  private $Chave ;

  public function atualSenha()
  {
      $this->Chave = filter_input(INPUT_GET,"chave", FILTER_SANITIZE_STRING);

      if (!empty($this->Chave)) {
          

      } else {
        $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Link Ivalido!</div>";
                $UrlDestino = URLADM . 'login/acesso';
                header("Location: $UrlDestino");
      }
      

  }

}