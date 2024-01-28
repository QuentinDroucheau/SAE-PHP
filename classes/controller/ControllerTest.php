<?php 

namespace controller;

class ControllerTest extends Controller{

    public function view(){
        $this->render("base", [
            "header" => $this->get("element/header"),
            "menu" => $this->get("element/menu"),
            "content" => $this->get("test")
        ]);
    }
}