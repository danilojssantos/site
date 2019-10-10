<?php

namespace App\adms\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class SincroPgNivAc
{

    public function sincroPgNivAc()
    {
        $sincroPgNivAc = new \App\adms\Models\AdmsSincroPgNivAc();
        $sincroPgNivAc->sincroPgNivAc();
        $UrlDestino = URLADM . "nivel-acesso/listar";
        header("Location: $UrlDestino");
    }

}
