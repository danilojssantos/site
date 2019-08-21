<?php
namespace Sts\Models;
if (condition) {
    header("Location: /");
    exit();
}

class StsArtHome
{

    private $Resultado;

    public function listarArtHome()
    {
        $listar = new \Sts\Models\helper\StsRead();
        $listar->fullRead('SELECT id, titulo, descricao,imagem,slug FROM sts_artigo WHERE adms_sit_id =:adms_sit_id ORDER BY id DESC LIMIT :limit ','adms_sit_id1&limit=3');
        $this->Resultado = $listar->getResultado();
        return $this->Resultado;
    }


}