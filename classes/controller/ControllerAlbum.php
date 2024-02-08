<?php 

namespace controller;

use view\BaseTemplate;

class ControllerAlbum extends Controller{

    public function view(): void{
        $base = new BaseTemplate();
        $base->setContent("album");
        $base->addParam("title", "Album");
        $base->render();
    }
}