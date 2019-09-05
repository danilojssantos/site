<?php

namespace Sts\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class StsSeo
{

    private $Resultado;
    private $UrlController;
    private $Url;
    private $UrlConjunto;
    private $UrlParamentro;
    private $ResultadoFac;
    private static $Format;

    public function listarSeo()
    {
        $this->montarUrl();
        //echo $this->UrlController;
        $listar = new \Sts\Models\helper\StsRead();
        $listar->fullRead('SELECT pg.id, pg.endereco, pg.titulo, pg.keywords, pg.description,pg.author, pg.imagem,
                rob.tipo tipo_rob
                FROM sts_paginas pg
                INNER JOIN sts_robots rob ON rob.id=pg.sts_robot_id
                WHERE pg.controller =:controller
                ORDER BY pg.id ASC
                LIMIT :limit', "controller={$this->UrlController}&limit=1");                
        $this->Resultado = $listar->getResultado();
        
        $listarFac = new \Sts\Models\helper\StsRead();
        $listarFac->fullRead('SELECT og_site_name, og_locale, fb_admins, twitter_site FROM sts_seo WHERE id =:id LIMIT :limit', "id=1&limit=1");
        $this->ResultadoFac = $listarFac->getResultado();
        $this->Resultado[0]['og_site_name'] = $this->ResultadoFac[0]['og_site_name'];
        $this->Resultado[0]['og_locale'] = $this->ResultadoFac[0]['og_locale'];
        $this->Resultado[0]['fb_admins'] = $this->ResultadoFac[0]['fb_admins'];
        $this->Resultado[0]['twitter_site'] = $this->ResultadoFac[0]['twitter_site'];
        //var_dump($this->ResultadoFac);
        //var_dump($this->Resultado);
        return $this->Resultado;
    }

    private function montarUrl()
    {
        if (!empty(filter_input(INPUT_GET, 'url', FILTER_DEFAULT))) {
            $this->Url = filter_input(INPUT_GET, 'url', FILTER_DEFAULT);
            $this->limparUrl();
            $this->UrlConjunto = explode("/", $this->Url);

            if (isset($this->UrlConjunto[0])) {
                $this->UrlController = $this->slugController($this->UrlConjunto[0]);
            } else {
                $this->UrlController = $this->slugController(CONTROLER);
            }

            if (isset($this->UrlConjunto[1])) {
                $this->UrlParametro = $this->UrlConjunto[1];
            } else {
                $this->UrlParametro = null;
            }
            //echo "URL: {$this->Url} <br>";
            //echo "Controlle: {$this->UrlController} <br>";
        } else {
            $this->UrlController = $this->slugController(CONTROLER);
            $this->UrlParametro = null;
        }
    }

    private function limparUrl()
    {
        //Eliminar as tags
        $this->Url = strip_tags($this->Url);
        //Eliminar espaços em branco
        $this->Url = trim($this->Url);
        //Eliminar a barra no final da URL
        $this->Url = rtrim($this->Url, "/");

        self::$Format = array();
        self::$Format['a'] = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()_-+={[}]?;:.,\\\'<>°ºª ';
        self::$Format['b'] = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr--------------------------------';
        $this->Url = strtr(utf8_decode($this->Url), utf8_decode(self::$Format['a']), self::$Format['b']);
    }
    
    private function slugController($SlugController)
    {
        $UrlController = str_replace(" ", "", ucwords(implode(" ", explode("-", strtolower($SlugController)))));
        return $UrlController;
    }

}
