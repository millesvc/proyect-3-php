<?php
/**
 * Router simple basado en el parámetro GET 'route'.
 * Compatible con PHP 7.3.
 */

class Router {
    private $routes = array();

    public function get($route, $controller, $method) {
        $this->routes['GET'][$route] = array($controller, $method);
    }

    public function post($route, $controller, $method) {
        $this->routes['POST'][$route] = array($controller, $method);
    }

    public function dispatch() {
        $httpMethod = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET';
        $route = isset($_GET['route']) ? $_GET['route'] : 'auth/login';

        if (isset($this->routes[$httpMethod][$route])) {
            list($controllerName, $methodName) = $this->routes[$httpMethod][$route];

            $controllerFile = BASE_PATH . "/controllers/{$controllerName}.php";

            if (!file_exists($controllerFile)) {
                http_response_code(404);
                die("Controlador '{$controllerName}' no encontrado.");
            }

            require_once $controllerFile;

            if (!class_exists($controllerName)) {
                http_response_code(500);
                die("Clase '{$controllerName}' no existe.");
            }

            $controller = new $controllerName();

            if (!method_exists($controller, $methodName)) {
                http_response_code(404);
                die("Método '{$methodName}' no encontrado en '{$controllerName}'.");
            }

            $controller->$methodName();
            return;
        }

        $base = rtrim(BASE_URL, '/');
        header("Location: {$base}/?route=auth/login");
        exit;
    }
}
