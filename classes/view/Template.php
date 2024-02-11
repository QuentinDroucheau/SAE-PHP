<?php 

namespace view;

abstract class Template extends Element{
    
    abstract public function render(): void;
}