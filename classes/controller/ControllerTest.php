<?php 

namespace controller;

use view\BaseTemplate;
use view\Template;

class ControllerTest extends Controller{

    public function view(){
        $base = new BaseTemplate();
        $base->setContent("test");
        $base->addParam("a", "nenfbeubf");
        $base->render();
    }
}