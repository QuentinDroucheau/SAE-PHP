<?php 

namespace route;

class Route{

    public function __construct(
        private string $url,
        private string $method,
        private string $controller,
        private string $action,
        private array $roles = [],
        private array $params = []
    ){}

    public function getController(): string{
        return $this->controller;
    }

    public function getUrl(): string{
        return $this->url;
    }

    public function getMethod(): string{
        return $this->method;
    }

    public function getAction(): string{
        return $this->action;
    }

    public function getRoles(): array{
        return $this->roles;
    }

    public function getParams(): array{
        return $this->params;
    }
}