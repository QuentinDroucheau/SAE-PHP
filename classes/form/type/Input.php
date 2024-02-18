<?php 

namespace form\type;

use form\InputRender;

abstract class Input implements InputRender{

    protected string $type;
    protected string $label = "";

    /**
     * @param string $value
     * @param bool $required
     * @param string $name
     * @param string $id
     */
    public function __construct(
        protected string $value,
        protected bool $required,
        protected string $name,
        protected string $id
    ){}

    public function __toString(){
        return $this->render();
    }

    /**
     * @param string $label
     * @return Input
     */
    public function setLabel(string $label): Input{
        $this->label = sprintf("<label for='%s'>%s</label>", $this->id, $label);
        return $this;
    }

    /**
     * @return string
     */
    public function render(): string{
        $required = $this->required ? "required=true" : "";
        $value = $this->value === "" ? "" : "value='".$this->value."'";

        $input = sprintf("<input type='%s' %s %s id='%s' name='%s'>", $this->type, $required, $value, $this->id, $this->name);

        return $this->label.$input;
    }
}