<?php 

namespace controller;

use utils\Utils;
use view\BaseTemplate;

class ControllerAlbum extends Controller{

    public function view(): void{
        $base = new BaseTemplate();
        $base->setContent("album");
        $base->addParam("title", "Album");
        $base->addParam("utilisateur", is_null($c = Utils::getConnexion()) ? "Connexion" : $c->getPseudoU());
        $base->render();
    }
}