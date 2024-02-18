<?php 

namespace view;

abstract class Template extends Element{
    
    /**
     * @return void
     */
    abstract public function render(): void;
}