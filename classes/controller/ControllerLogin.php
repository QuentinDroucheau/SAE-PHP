<?php 

namespace controller;

use form\Form;
use form\type\Submit;
use form\type\Text;
use models\db\UtilisateurDB;
use models\Utilisateur;
use utils\Utils;

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
     * @return Form
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

    /**
     * retourne le formulaire d'inscription
     * @return Form
     */
    private function getInscriptionForm(): Form{
        $form = new Form("javascript:void(0);", Form::POST, "inscription-form");
        $form->addInput((new Text("", true, "inscription-pseudo", "inscription-pseudo"))->setLabel("Pseudo"));
        $form->addInput((new Text("", true, "inscription-mail", "inscription-mail"))->setLabel("Mail"));
        $form->addInput((new Text("", true, "inscription-password", "inscription-password"))->setLabel("Mot de passe"));
        $form->addInput((new Text("", true, "inscription-confirmation", "inscription-confirmation"))->setLabel("Confirmer le mot de passe"));
        $form->addInput(new Submit("Valider", "inscription-button"));
        return $form;
    }

    /**
     * methode ajax pour récupérer le formulaire d'inscription
     * @return void
     */
    public function ajaxGetInscriptionForm(): void{
        echo json_encode($this->getInscriptionForm()->render());
        die();
    }

    /**
     * methode ajax pour récupérer le formulaire de connexion
     * @return void
     */
    public function ajaxGetLoginForm(): void{
        echo json_encode($this->getForm()->render());
        die();
    }

    /**
     * methode ajax pour récupérer le formulaire de changement de mot de passe
     * @return void
     */
    public function ajaxGetPasswordForm(): void{
        echo json_encode($this->getPasswordForm()->render());
        die();
    }

    /**
     * @return void
     */
    public function ajaxValidePasswordForm(): void{
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
     * @return void
     */
    public function logout(): void{
        Utils::logout();
        $this->redirect("/");
    }

    /**
     * @return void
     */
    public function ajaxValideLoginForm(): void{
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

    /**
     * @return void
     */
    public function ajaxValideInscriptionForm(): void{
        if(isset($this->params["inscription-pseudo"])
            and isset($this->params["inscription-mail"])
            and isset($this->params["inscription-password"])
            and isset($this->params["inscription-confirmation"])
        ){
            $pseudo = $this->params["inscription-pseudo"];
            $mail = $this->params["inscription-mail"];
            $password = $this->params["inscription-password"];
            $confirmation = $this->params["inscription-confirmation"];

            if($password === $confirmation){

                if(is_null(UtilisateurDB::getUtilisateurByPseudo($pseudo))){
                    
                    $utilisateur = UtilisateurDB::addUtilisateur(
                        $pseudo,
                        $password,
                        Utilisateur::ROLE_USER
                    );
                    Utils::login($utilisateur);

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
}