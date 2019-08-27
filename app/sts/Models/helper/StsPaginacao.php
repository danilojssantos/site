<?php
namespace Sts\Models\helper;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class StsPaginacao 
{
    private $Link;
    private $MaxLinks;
    private $Pagina;
    private $LimiteResultado;
    private $Offset;
    private $Query;
    private $ParseString;

    function __construct($Link)
    {

        $this->Link = $Link;
        echo "<br><br><br> {$this->Link}";

        $this->MaxLink = 2;
    }    

    //cria a regra da paginação 
    public function condicao($Pagina, $LimitResultado)
    {
        $this->Pagina = (int) $Pagina ? $Pagina :1;
        $this->LimiteResultado = (int) $LimitResultado;
        $this->Offset = ($this->Pagina * $this->LimiteResultado) - $this->LimiteResultado;
    }

    public function paginacao($Query, $ParseString = null)
    {
        $this->Query = (string) $Query;
        $this->ParseString = (string) $ParseString;
    }



}
