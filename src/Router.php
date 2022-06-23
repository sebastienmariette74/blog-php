<?php

namespace App;

use AltoRouter;

class Router {

    private string $viewPath;
        
    private AltoRouter $router;

    public function __construct(string $viewPath)
    {
        $this->viewPath = $viewPath;
        $this->router = new AltoRouter();
    }

    public function get (string $url, string $view, ?string $name = null): self // self = le retour sera la class
    {
        $this->router->map('GET', $url, $view, $name);
        return $this;
    }

    public function url (string $name, array $params = [])
    {
        return $this->router->generate($name, $params);
    }

    public function run (): self
    {
        $match = $this->router->match();
        $params = $match['params'];
        $view = $match['target'];
        $router = $this;
        ob_start();
        require $this->viewPath . $view . '.php';
        $content = ob_get_clean();
        require $this->viewPath . DIRECTORY_SEPARATOR . 'layouts/default.php';
        return $this;
    }

}