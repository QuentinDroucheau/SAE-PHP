<?php 

namespace controller;

use form\Form;
use form\type\Number;
use form\type\Submit;
use form\type\Text;
use models\db\AlbumDB;
use models\db\NoteDB;
use utils\Utils;
use view\BaseTemplate;

class ControllerAlbum extends Controller{

    public function view(): void{
        $albumId = $this->params["id"];

        $base = new BaseTemplate();
        $base->setContent("album");
        $base->addParam("title", "Album");
        $base->addParam("album", AlbumDB::getAlbum($albumId));
        $base->addParam("note", AlbumDB::getNoteAlbum($albumId));
        $base->addParam("utilisateur", is_null($c = Utils::getConnexion()) ? "Connexion" : $c->getPseudoU());
        $base->addParam("musiques", AlbumDB::getMusiques($albumId));
        $base->addParam("notes", NoteDB::getNotes($albumId));
        $base->render();
    }

    private function getCritiqueForm(): Form{
        //              action géré par le javascript
        $form = new Form("javascript:void(0);", Form::POST, "critique-form");
        $form->addInput((new Text("", true, "critique", "critique"))->setLabel("Critique :"));
        $form->addInput((new Number("", true, "note", "note", 0, 10))->setLabel("Note :"));
        $form->addInput(new Submit("Confirmer", "critique-button"));
        return $form;
    }

    public function ajaxGetCritiqueForm(){
        echo json_encode($this->getCritiqueForm()->render());
        die();
    }

    public function ajaxAddCritique(){
        $albumId = $this->params["id"];
        $note = $this->params["note"];
        $critique = $this->params["critique"];
        $user = Utils::getConnexion()?->getId();

        if(is_null($user)){
            echo json_encode(["success" => false]);
            die();
        }else{
            NoteDB::addCritique($albumId, $user, $note, $critique);
            echo json_encode(["success" => true]);
            die();
        }
    }
}