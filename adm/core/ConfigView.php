<?php

namespace Core;

/**
 * Description of ConfigView
 *
 * @copyright (c) year, Cesar Szpak - Celke
 */
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

    public function renderizarLogin()
    {
        include 'app/adms/Views/include/cabecalho.php';
        if (file_exists('app/' . $this->Nome . '.php')) {
            include 'app/' . $this->Nome . '.php';
        }else{
            echo "Erro ao carregar a Página: {$this->Nome}";
        }
    }

}
