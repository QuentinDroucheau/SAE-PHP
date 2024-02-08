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
    public function redirect(string $url, string $action): void{
        header("Location: ".$url."&action=".$action);
        exit;
    }
}