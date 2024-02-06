<?php 

namespace view;

class Template{

     /**
     * affiche une vue
     * @param string $view nom de la vue
     * @param array $variale
     */
    public static function render(string $view, array $variable = []): void{
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
    public static function get(string $view, array $variable = []): string{
        ob_start();
        extract($variable);
        require "view/".$view.".php";
        $content = ob_get_clean();
        return $content;
    }
}