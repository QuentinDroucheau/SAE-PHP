<?php 

namespace form\type;

class Submit extends Input{

    protected string $type = "submit";

    public function __construct(string $name, string $id){
        parent::__construct($name, true, "", $id);
    }
}