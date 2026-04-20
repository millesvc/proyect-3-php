<?php
/**
 * Clase base Controller.
 * Compatible con PHP 7.3.
 */

abstract class Controller {
    protected function render($view, $data = array()) {
        extract($data);

        $viewPath = BASE_PATH . "/views/{$view}.php";

        if (!file_exists($viewPath)) {
            http_response_code(404);
            die("Vista '{$view}' no encontrada.");
        }

        require $viewPath;
    }

    protected function redirect($path) {
        $base = rtrim(BASE_URL, '/');
        header("Location: {$base}{$path}");
        exit;
    }

    protected function sanitize($input) {
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }

    protected function post($key) {
        return isset($_POST[$key]) ? trim($_POST[$key]) : '';
    }

    protected function get($key) {
        return isset($_GET[$key]) ? $this->sanitize($_GET[$key]) : '';
    }
}
