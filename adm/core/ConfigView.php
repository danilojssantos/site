<?php

namespace Core;


class ConfigView
{

    private $Nome;
    private $Dados;

    public function __construct($Nome, array $Dados = null)
    {
        $this->Nome = (string) $Nome;
        $this->Dados = $Dados;
    }

    public function renderizar()
    {
        if (file_exists('app/' . $this->Nome . '.php')) {
          
            include 'app/' . $this->Nome . '.php';
            
        }else{
            echo "Erro ao carregar a Página: {$this->Nome}";
        }
    }

}
