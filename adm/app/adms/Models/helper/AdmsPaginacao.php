<?php

namespace App\adms\Models\helper;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AdmsPaginacao
{

    private $Link;
    private $Pagina;
    private $LimiteResultado;
    private $Offset;
    private $Query;
    private $ParseString;
    private $ResultBd;
    private $Resultado;
    private $TotalPaginas;

    function getResultado()
    {
        return $this->Resultado;
    }

    function getOffset()
    {
        return $this->Offset;
    }

    function __construct($Link)
    {
        $this->Link = $Link;
    }

    public function condicao($Pagina, $LimiteResultado)
    {
        $this->Pagina = (int) $Pagina ? $Pagina : 1;
        $this->LimiteResultado = (int) $LimiteResultado;
        $this->Offset = ($this->Pagina * $this->LimiteResultado) - $this->LimiteResultado;
    }

    public function paginacao($Query, $ParseString = null)
    {
        $this->Query = (string) $Query;
        $this->ParseString = (string) $ParseString;
        $contar = new \App\adms\Models\helper\AdmsRead();
        $contar->fullRead($this->Query, $this->ParseString);
        $this->ResultBd = $contar->getResultado();
        if ($this->ResultBd[0]['num_result'] > $this->LimiteResultado) {
            $this->instrucaoPaginacao();
        } else {
            $this->Resultado = null;
        }
    }

    private function instrucaoPaginacao()
    {
        $this->TotalPaginas = ceil($this->ResultBd[0]['num_result'] / $this->LimiteResultado);
        if($this->TotalPaginas >= $this->Pagina){
            echo "Paginacao";
        }else{
            header("Location: {$this->Link}");
        }
    }

}
