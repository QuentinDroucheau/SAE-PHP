<?php 

namespace route;

class Route{

    /**
     * @param string $url
     * @param string $method
     * @param string $controller
     * @param string|null $action
     * @param array $roles
     * @param array $params
     */
    public function __construct(
        private string $url,
        private string $method,
        private string $controller,
        private ?string $action = null,
        private array $roles = [],
        private array $params = []
    ){}

    /**
     * controller qui s'occupe de la route
     * @return string
     */
    public function getController(): string{
        return $this->controller;
    }

    /**
     * url de la route
     * @return string
     */
    public function getUrl(): string{
        return $this->url;
    }

    /**
     * méthode de la route
     * @return string
     */
    public function getMethod(): string{
        return $this->method;
    }

    /**
     * action par défaut (methode appelée dans le controller)
     * @return string|null
     */
    public function getAction(): ?string{
        return $this->action;
    }

    /**
     * roles autorisés à accéder à la route (vide = tout le monde)
     * @return array
     */
    public function getRoles(): array{
        return $this->roles;
    }

    /**
     * paramètres de la route obligatoire
     * @return array
     */
    public function getParams(): array{
        return $this->params;
    }
}