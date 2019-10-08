<?php

namespace App\adms\Models\helper;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsSlug
 *
 * @copyright (c) year, Cesar Szpak - Celke
 */
class AdmsSlug
{
    private $Nome;
private $Formato;

    public function nomeSlug($Nome)
    {
        $this->Nome = (string) $Nome;
        $this->Formato['a'] = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()_-+={[}]/?;:,\\\'<>°ºª';
        $this->Formato['b'] = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr                                ';
        
        $this->Nome = strtr(utf8_decode($this->Nome), utf8_decode($this->Formato['a']), $this->Formato['b']);
        $this->Nome = strip_tags($this->Nome);
        
        $this->Nome = str_replace(' ', '-', $this->Nome);
        
        $this->Nome = str_replace(array('-----','----','---','--'), '-', $this->Nome);
        
        $this->Nome = strtolower($this->Nome);
        
        return $this->Nome;
        
    }
}
