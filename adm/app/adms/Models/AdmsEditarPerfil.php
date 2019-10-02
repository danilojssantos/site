<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AdmsEditarPerfil
{

    private $Resultado;
    private $Dados;
    private $Foto;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function altPerfil(array $Dados)
    {
        $this->Dados = $Dados;
        var_dump($this->Dados);
        $this->Foto = $this->Dados['imagem'];
        unset($this->Dados['imagem']);

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $valEmail = new \App\adms\Models\helper\AdmsEmail();
            $valEmail->valEmail($this->Dados['email']);

            $valEmailUnico = new \App\adms\Models\helper\AdmsEmailUnico();
            $EditarUnico = true;
            $valEmailUnico->valEmailUnico($this->Dados['email'], $EditarUnico, $_SESSION['usuario_id']);

            $valUsuario = new \App\adms\Models\helper\AdmsValUsuario();
            $valUsuario->valUsuario($this->Dados['usuario'], $EditarUnico, $_SESSION['usuario_id']);

            if (( $valUsuario->getResultado()) AND ( $valEmailUnico->getResultado()) AND ( $valEmail->getResultado())) {
                $this->valFoto();
            } else {
                $this->Resultado = false;
            }
        } else {
            $this->Resultado = false;
        }
    }

    private function valFoto()
    {
        if (empty($this->Foto['name'])) {
            $this->updateEditPerfil();
        }else{

            $slugImg = new \App\adms\Models\helper\AdmsSlug();
           
            $this->Dados['imagem'] = $slugImg->nomeSlug($this->Foto['name']);
        
            $uploadImg = new \App\adms\Models\helper\AdmsUploadImgRed();
            $uploadImg->uploadImagem($this->Foto, 'assets/imagens/usuario/'.$_SESSION['usuario_id'].'/', $this->Dados['imagem'], 150, 150);
            if($uploadImg->getResultado()){
                $apagarImg = new \App\adms\Models\helper\AdmsApagarImg();
                $apagarImg->apagarImg('assets/imagens/usuario/' . $_SESSION['usuario_id'] . '/' . $this->ImgAntiga);
                $this->updateEditPerfil();
            }else{
                $this->Resultado = false;
            }
        }
    }

    private function updateEditPerfil()
    {
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAltSenha = new \App\adms\Models\helper\AdmsUpdate();
        $upAltSenha->exeUpdate("adms_usuarios", $this->Dados, "WHERE id =:id", "id=" . $_SESSION['usuario_id']);
        if ($upAltSenha->getResultado()) {
            $_SESSION['usuario_nome'] = $this->Dados['nome'];
            $_SESSION['usuario_email'] = $this->Dados['email'];
            $_SESSION['usuario_imagem'] = $this->Dados['imagem'];
            $_SESSION['msg'] = "<div class='alert alert-success'>Perfil atualizado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O perfil não foi atualizado!</div>";
            $this->Resultado = false;
        }
    }

}
