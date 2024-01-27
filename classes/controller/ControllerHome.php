<?php 

namespace controller;

class ControllerHome extends Controller{

    public function view(): void{
        $this->render("test2.php", [
            "test" => $this->get("test3.php")
        ]);
    }

    public function add(): void{
        $this->render("test.php", []);
    }
}