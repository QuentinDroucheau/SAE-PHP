<?php 

namespace controller;

use form\Form;
use form\type\Submit;
use form\type\Text;
use models\db\UtilisateurDB;
use utils\Utils;
use view\BaseTemplate;

class ControllerLogin extends Controller{

    /**
     * retourne le formulaire de connexion
     * @return Form
     */
    private function getForm(): Form{
        $form = new Form("javascript:void(0);", Form::POST, "login-form");
        $form->addInput((new Text("", true, "login-pseudo", "login-pseudo"))->setLabel("Pseudo/mail"));
        $form->addInput((new Text("", true, "login-password", "login-password"))->setLabel("Mot de passe"));
        $form->addInput(new Submit("Se connecter", "login-button"));
        return $form;
    }

    /**
     * retourne le formulaire pour changer le mot de passe
     */
    private function getPasswordForm(): Form{
        //              action géré par le javascript
        $form = new Form("javascript:void(0);", Form::POST, "password-form");
        $form->addInput((new Text("", true, "password-old", "password-old"))->setLabel("Ancient mot de passe"));
        $form->addInput((new Text("", true, "password-new", "password-new"))->setLabel("Nouveau mot de passe"));
        $form->addInput((new Text("", true, "password-confirmation", "password-confirmation"))->setLabel("Confirmer le mot de passe"));
        $form->addInput(new Submit("Confirmer", "password-button"));
        return $form;
    }

    public function ajaxGetLoginForm(){
        echo json_encode($this->getForm()->render());
        die();
    }

    public function ajaxGetPasswordForm(){
        echo json_encode($this->getPasswordForm()->render());
        die();
    }

    public function ajaxValidePasswordForm(){
        if(isset($this->params["password-old"]) and
            isset($this->params["password-new"]) and
            isset($this->params["password-confirmation"])
        ){
            $old = $this->params["password-old"];
            $new = $this->params["password-new"];
            $confirmation = $this->params["password-confirmation"];

            if($new === $confirmation){
                $utilisateur = Utils::getConnexion();
                if($utilisateur->getMdpU() === $old){
                    $utilisateur->setMdpU($new);
                    Utils::login(UtilisateurDB::update($utilisateur));

                    echo json_encode([
                        "success" => true
                    ]);
                    die();
                }
            }
        }

        echo json_encode([
            "success" => false
        ]);
        die();
    }

    /**
     * déconnection de l'utilisateur
     */
    public function logout(){
        Utils::logout();
        $this->redirect("/");
    }

    public function ajaxValideLoginForm(){
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