<?php 

namespace controller;

abstract class Controller{

    protected array $params;

    public function __construct(array $params = []){
        $this->params = $params;
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