<?php

namespace Core;


class ConfigController
{

    private $Url;
    private $UrlConjunto;
    private $UrlController;
    private $UrlParametro;
    private $UrlMetodo;
    private $Classe;
    private $Paginas;
    private static $Format;

    public function __construct()
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
                $this->UrlMetodo = $this->UrlConjunto[1];
            } else {
                $this->UrlController = $this->slugController(METODO);
            }

            if (isset($this->UrlConjunto[2])) {
                $this->UrlParametro = $this->UrlConjunto[2];
            } else {
                $this->UrlParametro = null;
            }
           // echo "URL: {$this->Url} <br>";
            //echo "Controlle: {$this->UrlController} <br>";
        } else {
            $this->UrlController = $this->slugController(CONTROLER);
            $this->UrlController = $this->slugController(METODO);
            $this->UrlParametro = null;
        }

         //echo "URL: {$this->Url} <br>";
         //echo "Controlle: {$this->UrlController} <br>";
         //echo "Metodo: {$this->UrlMetodo} <br>";
         //echo "Paramento: {$this->UrlParametro} <br>";


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

    public function slugController($SlugController)
    {
        
        $UrlController = str_replace(" ", "", ucwords(implode(" ", explode("-", strtolower($SlugController)))));
        return $UrlController;
    }

    public function carregar()
    {
        $listarPg = new \App\adms\Models\admsPaginas();
        $this->Paginas = $listarPg->listarPaginas($this->UrlController, $this->UrlMetodo);
        

        if ($this->Paginas) {
            extract($this->Paginas[0]);

    
            $this->Classe = "\\App\\{$tipo_tpg}\\Controllers\\" . $this->UrlController;

            if (class_exists($this->Classe)) {    

                $this->carregarMetodo();
              
            }else{
                $this->UrlController = $this->slugController(CONTROLER);
                $this->UrlController = $this->slugController(METODO);
                $this->carregar(); 
            }
        }else{
            $this->UrlController = $this->slugController(CONTROLER);
            $this->UrlController = $this->slugController(METODO);
            $this->carregar(); 

        }
      
    }


    public function carregarMetodo()
    {
        $classeCarregar = new $this->Classe;

        if (method_exists($classeCarregar, $this->UrlMetodo)) {
            if ($this->UrlParametro !== null) {
                $classeCarregar->{$this->UrlMetodo}($this->UrlParametro);
            }else{
                $classeCarregar->{$this->UrlMetodo}();
            }
        }else{
            $this->UrlController = $this->slugController(CONTROLER);
            $this->UrlMetodo = $this->slugController(METODO);
            $this->carregar();
        }
    }

   

}
