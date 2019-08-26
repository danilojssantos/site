<?php

namespace Core;


class ConfigController {

    private $Url;
    private $UrlConjunto;
    private $UrlController;
    private $UrlParamentro;
    public static $Format;

    public function __construct()
    {
        //echo "deu bom " ;  
        if(!empty(filter_input(INPUT_GET, 'url', FILTER_DEFAULT))){
            $this->Url = filter_input(INPUT_GET, 'url', FILTER_DEFAULT);
            $this->limparUrl();
            $this->UrlConjunto = explode("/", $this->Url);
           
            if(isset($this->UrlConjunto[0]))
            {
               $this->UrlController = $this->slugController($this->UrlConjunto[0]);
            }else{
                $this->UrlController = CONTROLER;
            }

            //condição dos segundo paramentro 
            if(isset($this->UrlConjuto[1]))
            {
               $this->UrlParamentro = $this->UrlConjunto[1];
            }else{
                $this->UrlParamentro = null;
            }

           // echo "{$this->Url} <br>";
           // echo "Controller: {$this->UrlController}  <br>";
            //  caso nao tenha paramentro entra else aonde vai ter valores fixos
        }else{
            $this->UrlController = CONTROLER;
            $this->UrlParamentro= null;
        }
      

    }

        // função responsavel por retirar os caracteres especial na URL 

            private function limparUrl()
            {
                //elimina as tags digitadas pelos usuarios

               $this->Url = strip_tags($this->Url);

               //eliminar os espaços em branco 

               $this->Url = trim($this->Url);

               //eliminar a barra no final da Url 

               $this->Url = rtrim($this->Url, "/");
                //substituir os caracteres especial 
               self::$Format = array();
               self::$Format['a'] = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()_-+={[}]?;:.,\\\'<>°ºª ';
               self::$Format['b'] = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr--------------------------------';
                //substistiu um array pelo outro 
             $this->Url =  strtr(utf8_decode($this->Url), utf8_decode(self::$Format['a']), self::$Format['b']);     
            }


            private function slugController($SlugController)
            {
                //$UrlController = strtolower($SlugController);
                //$UrlController = explode("-", $UrlController);
                //$UrlController = implode(" ", $UrlController);
                //$UrlController = ucwords($UrlController);
                //$UrlController = str_replace(" ", "", $UrlController);
                $UrlController = str_replace(" ", "", ucwords(implode(" ", explode("-", strtolower($SlugController)))));
                return $UrlController;
            }


            public function carregar()
            {
               // echo "carregando deu bom";
                if (file_exists('app/sts/Controllers/' . $this->UrlController . '.php')) {
                    $classe = "\\Sts\\Controllers\\" . $this->UrlController;
                } else {
                    $classe = "\\Sts\\Controllers\\Erro404";
                }
                
                $classeCarregar = new $classe; 
                $classeCarregar->index();
            }
}