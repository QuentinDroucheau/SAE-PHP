<?php 

namespace controller;

class ControllerHome extends Controller{

    public function view(): void{
        $this->render("test2", [
            "test" => $this->get("test3")
        ]);
    }

    public function add(): void{
        $this->render("test", []);
    }
}