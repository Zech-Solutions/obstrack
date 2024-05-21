<?php

class Router
{
    private $routes = [];

    public function get($uri, $controller)
    {
        $this->routes['GET'][$uri] = $controller;
    }

    public function post($uri, $controller)
    {
        $this->routes['POST'][$uri] = $controller;
    }

    public function dispatch()
    {
        $uri = $this->getUri() ?? "home";
        $method = $_SERVER['REQUEST_METHOD'];

        if (isset($this->routes[$method][$uri])) {
            $this->callControllerMethod(
                ...explode('@', $this->routes[$method][$uri])
            );
        } else {
            http_response_code(404);
            echo "404 Not Found";
        }
    }

    private function getUri()
    {
        $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        $uri = str_replace(ROUTE_URL, '', $uri);
        $uri = ltrim($uri, '/');
        return $uri == '' ? '' : $uri;
    }

    private function callControllerMethod($controller, $method)
    {
        require_once '../app/controllers/' . $controller . '.php';
        $controller = new $controller();
        call_user_func([$controller, $method]);
    }
}
