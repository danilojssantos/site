<?php
namespace Sts\Models\helper;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class StsPaginacao 
{
    private $Link;
    private $MaxLink;
    private $Pagina;
    private $LimiteResultado;
    private $Offset;
    private $Query;
    private $ParseString;
    private $ResultBd;
    private $Resultado;


    function getResultado()
    {
        return $this->Resultado;
    }

    function __construct($Link)
    {

        $this->Link = $Link;
        echo "<br><br><br> {$this->Link}";

        $this->MaxLink = 2;
    }    

    //cria a regra da paginação 
    public function condicao($Pagina, $LimitResultado)
    {
        
        $this->Pagina = (int) $Pagina ? $Pagina : 1;

        $this->LimiteResultado = (int) $LimitResultado;
        
        $this->Offset = ($this->Pagina * $this->LimiteResultado) - $this->LimiteResultado;
        
        
    }

    public function paginacao($Query, $ParseString = null)    
    {
        
        $this->Query = (string) $Query;

        $this->ParseString = (string) $ParseString;
        
        $contar = new \Sts\Models\helper\StsRead();
        
        $contar->FullRead($this->Query, $this->ParseString);
        
        $this->ResultBd = $contar->getResultado();
        
        var_dump($this->ResultBd);
        if ($this->ResultBd[0]['num_result'] > $this->LimiteResultado ) {
            $this->InstrucaoPaginacao();
        }else{
            $this->Resultado = null;
        }
    }



    private function InstrucaoPaginacao()
    {
        //funcao ceil coloca sempre o numero inteiro 
        $paginas = ceil($this->ResultBd[0]['num_result'] / $this->LimiteResultado);
      
        $this->Resultado = "<nav aria-label='paginacao'>";
        $this->Resultado .= "<ul class='pagination justify-content-center'>";
        $this->Resultado .= "<li class='page-item'>";
        $this->Resultado .= "<a class='page-link' href=\"{$this->Link}\" tabindex='-1'>Primeira</a>";
        $this->Resultado .= "</li>";
        $this->Resultado .= "<li class='page-item'><a class='page-link' href='#'>1</a></li>";
        $this->Resultado .= "<li class='page-item active'>";
        $this->Resultado .= "<a class='page-link' href='#'>2 <span class='sr-only'>(current)</span></a>";
        $this->Resultado .= "</li>";
        $this->Resultado .= "<li class='page-item'><a class='page-link' href='#'>3</a></li>";
        $this->Resultado .= "<li class='page-item'>";
        $this->Resultado .= "<a class='page-link' href='#'>Next</a>";
        $this->Resultado .= "</li>";
        $this->Resultado .= "</ul>";
        $this->Resultado .= "</nav>";
    }






}
