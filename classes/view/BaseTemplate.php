<?php 

namespace view;

class BaseTemplate extends Template{

    private string $content;

    /**
     * @param array $params = []
     */
    public function __construct(array $params = []){
        parent::__construct("base", $params);
    }

    /**
     * @param string $view
     * @return void
     */
    public function setContent(string $view): void{
        $this->content = $view;
    }

    /**
     * @return void
     */
    public function render(): void{
        extract($this->params);

        ob_start();
        require "view/".$this->content.".php";
        $content = ob_get_clean();
        $header = (new Composant("header", $this->params))->get();
        $menu = (new Composant("menu", $this->params))->get();
        $popup = (new Composant("popup", $this->params))->get();
        require "view/template/base.php";
    }
}