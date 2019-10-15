<?php

namespace Sts\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of StsHome
 *
 * @copyright (c) year, Cesar Szpak - Celke
 */
class StsCarousel
{

    private $Resultado;

    public function listar()
    {
        $listar = new \Sts\Models\helper\StsRead();
        //$listar->exeRead('sts_carousels', 'WHERE adms_situacoe_id =:adms_situacoe_id LIMIT :limit', 'adms_situacoe_id=1&limit=4');
        $listar->fullRead("SELECT car.id, car.nome, car.imagem, car.titulo, car.descricao, car.posicao_text, car.titulo_botao, car.link,
                cors.cor
                FROM sts_carousels car
                INNER JOIN adms_cors cors ON cors.id=car.adms_cor_id
                WHERE car.adms_sit_id =:adms_sit_id ORDER BY car.ordem ASC LIMIT :limit", 'adms_sit_id=1&limit=10');
        $this->Resultado['sts_carousels'] = $listar->getResultado();
        return $this->Resultado['sts_carousels'];
    }

}
