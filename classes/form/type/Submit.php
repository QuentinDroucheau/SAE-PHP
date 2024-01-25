<?php 

namespace form\type;

class Submit extends Input{

    protected string $type = "submit";

    public function __construct(string $name){
        parent::__construct($name, true, "", "");
    }
}