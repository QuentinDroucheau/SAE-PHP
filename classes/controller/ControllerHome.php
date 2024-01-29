<?php 
// 2 méthodes


namespace controller;

class ControllerHome extends Controller{

    public function view(): void{
        $this->render("home.php", []);
    }

    public function add(): void{
        $this->render("test.php", []);
    }
}