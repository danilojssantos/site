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
    private $MaxLinks = 2;
    private $Var;

    function getResultado()
    {
        return $this->Resultado;
    }

    function getOffset()
    {
        return $this->Offset;
    }

    function __construct($Link, $Var = null)
    {
        $this->Link = $Link;
        $this->Var = $Var;
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
        if ($this->TotalPaginas >= $this->Pagina) {
            $this->layoutPaginacao();
        } else {
            header("Location: {$this->Link}");
        }
    }

    private function layoutPaginacao()
    {
        $this->Resultado = "<nav aria-label='paginacao'>";
        $this->Resultado .= "<ul class='pagination pagination-sm justify-content-center'>";
        $this->Resultado .= "<li class='page-item'>";
        $this->Resultado .= "<a class='page-link' href='" . $this->Link . $this->Var . "' tabindex='-1'>Primeira</a>";
        $this->Resultado .= "</li>";
        for ($iPag = $this->Pagina - $this->MaxLinks; $iPag <= $this->Pagina - 1; $iPag++) {
            if ($iPag >= 1) {
                $this->Resultado .= "<li class='page-item'><a class='page-link' href='" . $this->Link . "/" . $iPag . $this->Var . "'>$iPag</a></li>";
            }
        }

        $this->Resultado .= "<li class='page-item active'>";
        $this->Resultado .= "<a class='page-link' href='#'>" . $this->Pagina . "</a>";
        $this->Resultado .= "</li>";
        for ($dPag = $this->Pagina + 1; $dPag <= $this->Pagina + $this->MaxLinks; $dPag++) {
            if ($dPag <= $this->TotalPaginas) {
                $this->Resultado .= "<li class='page-item'><a class='page-link' href='" . $this->Link . "/" . $dPag . $this->Var . "'>$dPag</a></li>";
            }
        }
        $this->Resultado .= "<li class='page-item'>";
        $this->Resultado .= "<a class='page-link' href='" . $this->Link . "/" . $this->TotalPaginas . $this->Var . "'>Última</a>";
        $this->Resultado .= "</li>";
        $this->Resultado .= "</ul>";
        $this->Resultado .= "</nav>";
    }

}
