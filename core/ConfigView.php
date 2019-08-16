<?php
namespace Core;

class ConfigView 
{

    private $Nome; //recebe o nome da pagina 
    private $Dados;//recebe os dados do banco
    public function __construct($Nome, array $Dados = null)
    {
        $this->Nome = (string) $Nome;
        $this->Dados = $Dados;
    }
    //metodo responsavel por buscar a pagina 

    public function renderizar()
    {
        //verifica se arquivo existe
        if (file_exists('app/'. $this->Nome . '.php')) 
        {
            include 'app/sts/Views/include/cabecalho.php';
            include 'app//sts/Views/include/menu.php';
            include 'app/'. $this->Nome . '.php';
            include 'app/sts/Views/include/rodape.php';
        } else{
            echo "erro carregar a Pagina {$this->Nome}";
        }
        
    }
}
