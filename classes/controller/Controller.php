<?php 

namespace controller;

abstract class Controller{

    protected array $params;

    public function __construct(array $params = []){
        $this->params = $params;
    }

    /**
     * affiche une vue
     * @param string $view
     * @param array $variale
     */
    public function render(string $view, array $variable = []){
        // converti le tableau en variable
        extract($variable);
        require "view/".$view;
    }

    /**
     * @param string $url
     * @param string $action méthode à appeller 
     */
    public function redirect(string $url, string $action): void{
        header("Location: ".$url."&action=".$action);
        exit;
    }
}