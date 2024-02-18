<?php 

namespace controller;

use form\Form;
use form\type\Number;
use form\type\Submit;
use form\type\Text;
use models\db\AlbumDB;
use models\db\NoteDB;
use utils\Utils;

class ControllerAlbum extends Controller{

    /**
     * affiche la vue d'un album
     * @return void
     */
    public function view(): void{
        $albumId = $this->params["id"];

        $this->template->setContent("album");
        $this->template->addParam("title", "Album");
        $this->template->addParam("album", AlbumDB::getAlbum($albumId));
        $this->template->addParam("note", AlbumDB::getNoteAlbum($albumId));
        $this->template->addParam("utilisateur", is_null($c = Utils::getConnexion()) ? "" : $c->getPseudoU());
        $this->template->addParam("musiques", AlbumDB::getMusiques($albumId));
        $this->template->addParam("notes", NoteDB::getNotes($albumId));
        $critique = false;
        if((!is_null(Utils::getConnexion())) and !(NoteDB::hasCritique($albumId, Utils::getConnexion()->getId()))){
            $critique = true;
        }
        $lesPlaylists = Utils::getPlaylistsMenu();
        $this->template->addParam("playlists", $lesPlaylists);
        $this->template->addParam("critique", $critique);
        $this->template->render();
    }

    /**
     * retourne le formulaire pour ajouter une critique
     * @return Form
     */
    private function getCritiqueForm(): Form{
        //              action géré par le javascript
        $form = new Form("javascript:void(0);", Form::POST, "critique-form");
        $form->addInput((new Text("", true, "critique", "critique"))->setLabel("Critique :"));
        $form->addInput((new Number("", true, "note", "note", 0, 10))->setLabel("Note :"));
        $form->addInput(new Submit("Confirmer", "critique-button"));
        return $form;
    }

    /**
     * methode ajax pour récupérer le formulaire de critique
     * @return void
     */
    public function ajaxGetCritiqueForm(): void{
        echo json_encode($this->getCritiqueForm()->render());
        die();
    }

    /**
     * methode ajax pour ajouter une critique
     * @return void
     */
    public function ajaxAddCritique(): void{
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