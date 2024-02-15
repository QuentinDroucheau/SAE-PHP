<?php 

namespace form\type;

class Number extends Input{

    protected string $type = "number";

    private int $min;
    private int $max;

    public function __construct(
        string $value,
        bool $required,
        string $name,
        string $id,
        int $min = 0,
        int $max = 100
    ){
        parent::__construct($value, $required, $name, $id);
        $this->min = $min;
        $this->max = $max;
    }

    public function render(): string{
        $required = $this->required ? "required=true" : "";
        $value = $this->value === "" ? "" : "value='".$this->value."'";

        $input = sprintf("<input type='%s' %s %s id='%s' name='%s' min='%s' max='%s'>", 
            $this->type, $required, $value, $this->id, $this->name,
            $this->min, $this->max);

        return $this->label.$input;
    }
}