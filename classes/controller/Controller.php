<?php 

namespace controller;

use view\BaseTemplate;

abstract class Controller{

    /**
     * liste des paramètres à passer dans l'url
     * @var array
     */
    protected array $params;

    /**
     * template à afficher
     * @var BaseTemplate
     */
    protected BaseTemplate $template;

    /**
     * @param array $params = []
     */
    public function __construct(array $params = []){
        $this->params = $params;
        $this->template = new BaseTemplate();
    }

    /**
     * @param string $url
     * @param string $action méthode à appeller 
     */
    public function redirect(string $url, ?string $action = null): void{
        if(is_null($action)){
            header( "Location: ".$url);
            exit;
        }
        header("Location: ".$url."&action=".$action);
        exit;
    }
}