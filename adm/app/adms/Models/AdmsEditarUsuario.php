<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsEditarUsuario
 *
 * @copyright (c) year, Cesar Szpak - Celke
 */
class AdmsEditarUsuario
{

    private $Resultado;
    private $Dados;
    private $DadosId;
    private $Foto;
    private $ImgAntiga;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function verUsuario($DadosId)
    {
        $this->DadosId = (int) $DadosId;
        $verPerfil = new \App\adms\Models\helper\AdmsRead();
        $verPerfil->fullRead("SELECT user.* FROM adms_usuarios user
                INNER JOIN adms_niveis_acessos nivac ON nivac.id=user.adms_niveis_acesso_id
                WHERE user.id =:id AND nivac.ordem >:ordem LIMIT :limit", "id=" . $this->DadosId . "&ordem=".$_SESSION['ordem_nivac']."&limit=1");
        $this->Resultado = $verPerfil->getResultado();
        return $this->Resultado;
    }

    public function altUsuario(array $Dados)
    {
        $this->Dados = $Dados;
        //var_dump($this->Dados);
        $this->Foto = $this->Dados['imagem_nova'];
        $this->ImgAntiga = $this->Dados['imagem_antiga'];
        unset($this->Dados['imagem_nova'], $this->Dados['imagem_antiga']);

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->valCampos();
        } else {
            $this->Resultado = false;
        }
    }

    private function valCampos()
    {
        $valEmail = new \App\adms\Models\helper\AdmsEmail();
        $valEmail->valEmail($this->Dados['email']);

        $valEmailUnico = new \App\adms\Models\helper\AdmsEmailUnico();
        $EditarUnico = true;
        $valEmailUnico->valEmailUnico($this->Dados['email'], $EditarUnico, $this->Dados['id']);

        $valUsuario = new \App\adms\Models\helper\AdmsValUsuario();
        $valUsuario->valUsuario($this->Dados['usuario'], $EditarUnico, $this->Dados['id']);

        if (( $valUsuario->getResultado()) AND ( $valEmailUnico->getResultado()) AND ( $valEmail->getResultado())) {
            $this->valFoto();
        } else {
            $this->Resultado = false;
        }
    }

    private function valFoto()
    {
        if (empty($this->Foto['name'])) {
            $this->updateEditUsuario();
        } else {
            $slugImg = new \App\adms\Models\helper\AdmsSlug();
            $this->Dados['imagem'] = $slugImg->nomeSlug($this->Foto['name']);

            $uploadImg = new \App\adms\Models\helper\AdmsUploadImgRed();
            $uploadImg->uploadImagem($this->Foto, 'assets/imagens/usuario/' . $this->Dados['id'] . '/', $this->Dados['imagem'], 150, 150);
            if ($uploadImg->getResultado()) {
                $apagarImg = new \App\adms\Models\helper\AdmsApagarImg();
                $apagarImg->apagarImg('assets/imagens/usuario/' . $this->Dados['id'] . '/' . $this->ImgAntiga);
                $this->updateEditUsuario();
            } else {
                $this->Resultado = false;
            }
        }
    }

    private function updateEditUsuario()
    {
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAltSenha = new \App\adms\Models\helper\AdmsUpdate();
        $upAltSenha->exeUpdate("adms_usuarios", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);
        if ($upAltSenha->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Usuário atualizado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O usuario não foi atualizado!</div>";
            $this->Resultado = false;
        }
    }

    public function listarCadastrar()
    {
        $listar = new \App\adms\Models\helper\AdmsRead();
        $listar->fullRead("SELECT id id_nivac, nome nome_nivac FROM adms_niveis_acessos WHERE ordem >=:ordem ORDER BY nome ASC", "ordem=" . $_SESSION['ordem_nivac']);
        $registro['nivac'] = $listar->getResultado();
        
        $listar->fullRead("SELECT id id_sit, nome nome_sit FROM adms_sits_usuarios ORDER BY nome ASC");
        $registro['sit'] = $listar->getResultado();
        
        $this->Resultado = ['nivac' => $registro['nivac'], 'sit' =>  $registro['sit']];
        
        return $this->Resultado;
    }

}
