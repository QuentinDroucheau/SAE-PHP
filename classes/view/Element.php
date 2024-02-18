<?php 

namespace view;

abstract class Element{

    protected string $name;
    protected array $params;

    /**
     * @param string $name
     * @param array $params = []
     */
    public function __construct(string $name, array $params = []){
        $this->name = $name;
        $this->params = $params;
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function addParam(string $name, mixed $value): void{
        $this->params[$name] = $value;
    }
}