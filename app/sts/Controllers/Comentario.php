<?php

namespace App\sts\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class Comentario
{

    private $Dados;

    public function index()
    {

        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->Dados['CadComent'])) {
            unset($this->Dados['CadComent']);
            $cadComent = new \Sts\Models\StsComentarios();
            $cadComent->cadComentario($this->Dados);
            if ($cadComent->getResultado()) {
                $this->Dados['form'] = null;
                unset($_SESSION['form']);
                $UrlDestino = URL . "artigo/" . $this->Dados['slug'] . "#msg_comentario";
                header("Location: $UrlDestino");
            } else {
                $_SESSION['form'] = $this->Dados;
                $UrlDestino = URL . "artigo/" . $this->Dados['slug'] . "#msg_comentario";
                header("Location: $UrlDestino");
            }
        }
    }

}
