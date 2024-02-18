<?php 

namespace view;

class Composant extends Element{

    /**
     * @return string
     */
    public function get(): string{
        extract($this->params);
        ob_start();
        require "view/composant/".$this->name.".php";
        $content = ob_get_clean();
        return $content;
    }
}