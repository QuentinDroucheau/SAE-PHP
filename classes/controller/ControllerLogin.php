<?php 

namespace controller;

use form\Form;
use form\type\Submit;
use form\type\Text;
use models\db\UtilisateurDB;
use utils\Utils;

class ControllerLogin extends Controller{

    public function view(): void{
        $this->render("element/login", [
            "form" => $this->getForm()
        ]);
    }

    /**
     * retourne le formulaire de connexion
     * @return Form
     */
    private function getForm(): Form{
        $form = new Form("javascript:void(0);", Form::POST, "login-form");
        $form->addInput((new Text("", true, "login-pseudo", "login-pseudo"))->setLabel("Pseudo/mail"));
        $form->addInput((new Text("", true, "login-password", "login-password"))->setLabel("Mot de passe"));
        $form->addInput(new Submit("Continuer", "login-button"));
        return $form;
    }

    public function ajaxGetLoginForm(){
        echo json_encode($this->getForm()->render());
        die();
    }

    public function ajaxValideForm(){
        if(isset($this->params["login-pseudo"])
            and isset($this->params["login-password"])
        ){
            $pseudo = $this->params["login-pseudo"];
            $password = $this->params["login-password"];

            $utilisateur = UtilisateurDB::getUtilisateurByPassword($pseudo, $password);
            if(!is_null($utilisateur)){
                
                Utils::login($utilisateur);

                echo json_encode([
                    "success" => true
                ]);
                die();
            }

        }

        echo json_encode([
            "success" => false
        ]);
        die();
    }
}