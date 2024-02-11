<?php 

namespace view;

class BaseTemplate extends Template{

    private string $content;

    public function __construct(array $params = []){
        parent::__construct("base", $params);
    }

    public function setContent(string $view): void{
        $this->content = $view;
    }

    public function render(): void{
        extract($this->params);

        ob_start();
        require "view/".$this->content.".php";
        $content = ob_get_clean();

        $header = (new Composant("header", $this->params))->get();
        $menu = (new Composant("menu", $this->params))->get();

        require "view/template/base.php";
    }
}