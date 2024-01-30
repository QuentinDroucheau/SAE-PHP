<?php 

namespace controller;

class ControllerAlbum extends Controller{

    public function view(): void{
        $id = $this->params["id"];
        $this->render("base", [
            "title" => "Album", 
            "content" => $this->get("album"),
            "header" => $this->get("element/header"),
            "menu" => $this->get("element/menu")
        ]);
    }
}