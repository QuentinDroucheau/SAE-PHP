<?php 

namespace form\type;

use form\InputRender;

abstract class Input implements InputRender{

    protected string $type;
    protected string $label = "";

    public function __construct(
        protected string $value,
        protected bool $required,
        protected string $name,
        protected string $id
    ){}

    public function __toString() {
        return $this->render();
    }

    public function setLabel(string $label){
        $this->label = sprintf("<label for='%s'>%s</label>", $this->id, $label);
        return $this;
    }

    public function render(): string{
        $required = $this->required ? "required=true" : "";
        $value = $this->value === "" ? "" : "value='".$this->value."'";

        $input = sprintf("<input type='%s' %s %s id='%s' name='%s'>", $this->type, $required, $value, $this->id, $this->name);

        return $this->label.$input;
    }
}