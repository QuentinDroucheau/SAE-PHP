<?php 

namespace form;

interface InputRender{

    /**
     * @return string
     */
    public function render(): string;
}