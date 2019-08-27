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

    function __construct($Link)
    {

        $this->Link = $Link;
        echo "<br><br><br> {$this->Link}";

        $this->MaxLink = 2;
    }    


    public function condicao($Pagina, $LimitResultado)
    {
        $this->Pagina = (int) $Pagina ? $Pagina :1;
        $this->LimiteResultado = (int) $LimitResultado;
        $this->Offset = ($this->Pagina * $this->LimiteResultado) - $this->LimiteResultado;
    }
}
