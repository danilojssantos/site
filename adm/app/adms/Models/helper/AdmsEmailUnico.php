<?php


namespace App\adms\Models\helper;
if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsEmailUnico 
{
private $Email;
private  $Resultado;

function getResultado()
{
    return $this->Resultado;
}

public function valEmailUnico($Email)
{
    $this->Email =  (string)  $Email;

    $valEmailUnico = new \App\adms\Models\helper\AdmsRead();

    $valEmailUnico->fullRead("SELECT id FROM adms_usuarios WHERE email =:email LIMIT :limit", "email={$this->Email}&limit=1");

    $this->Resultado = $valEmailUnico->getResultado();

    if (!empty($this->Resultado)) {
        $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Este e-mail já está cadastrado!</div>";
        $this->Resultado = false;
    } else {
        $this->Resultado = True ;
    }
    

}


}