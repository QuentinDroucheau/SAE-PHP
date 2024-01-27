<?php 

namespace controller;

abstract class Controller{

    protected array $params;

    public function __construct(array $params = []){
        $this->params = $params;
    }

    /**
     * affiche une vue
     * @param string $view nom de la vue
     * @param array $variale
     */
    public function render(string $view, array $variable = []): void{
        extract($variable);
        require "view/".$view.".php";
    }

    /**
     * retourne le contenu d'une vue 
     * utile pour imbriquer des vues entre elles
     * @param string $view nom de la vue
     * @param array $variable
     * @return string
     */
    public function get(string $view, array $variable = []): string{
        ob_start();
        extract($variable);
        require "view/".$view.".php";
        $content = ob_get_clean();
        return $content;
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