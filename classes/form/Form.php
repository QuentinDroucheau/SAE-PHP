<?php 

namespace form;

use form\type\Hidden;
use form\type\Input;
use form\type\Submit;

class Form implements InputRender{

    // type possible du formulaire
    public const POST = "POST";
    public const GET = "GET";

    /** @var Input[] */
    private array $input = [];

    /**
     * @param string $action
     * @param string $method
     * @param string $id id du formulaire
     */
    public function __construct(
        protected string $action,
        protected string $method,
        private string $id
    ){
        // ajoute au formulaire son identifiant
        $this->addInput(new Hidden($this->id, true, "form_id", "form_id"));
    }

    /**
     * @param Input $input
     * @return void
     */
    public function addInput(Input $input): void{
        $this->input[] = $input;
    }

    /**
     * @return array
     */
    public function getInputs(): array{
        return $this->input;
    }

    /**
     * ajoute une erreur à un formulaire
     * @param string $formId identifiant du formulaire
     * @param string $erreur a ajouter
     * @return void
     */
    public static function addError(string $formId, string $error): void{
        $_SESSION["form"][$formId]["erreurs"][] = $error;
    }

    /**
     * @return array
     */
    private function getErrors(): array{
        $errors = $_SESSION["form"][$this->id]["erreurs"] ?? [];
        unset($_SESSION["form"][$this->id]["erreurs"]);
        return $errors;
    }

    public function __toString(){
        return $this->render();
    }

    /**
     * @return string
     */
    public function render(): string{
        $form = sprintf("<form class='form' action='%s' method='%s'>", $this->action, $this->method);
        foreach($this->input as $input){
            // affiche les submits à la fin du formulaire
            if($input instanceof Submit){continue;}

            if($input instanceof Hidden){
                $form .= $input;
                continue;
            }

            $form .= sprintf("<div class='form-input'>%s</div>", $input);
        }

        // affiche toute les erreurs du formulaire 

        $form .= "<div class='form-errors'>";
        foreach($this->getErrors() as $error){
            $form .= "<p class='form-error'>".$error."</p>";
        }
        $form .= "</div>";

        $form .= "<div class='form-input'>";
        foreach($this->input as $input){
            if($input instanceof Submit){
                $form .= $input;
            }
        }

        $form .= "</div></form>";

        return $form;
    }
}