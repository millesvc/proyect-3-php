<?php
/**
 * Front Controller.
 * Compatible con PHP 7.3.
 */

define('BASE_PATH', dirname(__DIR__));

$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost:8000';
define('BASE_URL', $scheme . '://' . $host);

ini_set('session.cookie_httponly', '1');
ini_set('session.cookie_samesite', 'Strict');
ini_set('session.use_strict_mode', '1');

require_once BASE_PATH . '/core/Router.php';
require_once BASE_PATH . '/core/Controller.php';
require_once BASE_PATH . '/core/Model.php';
require_once BASE_PATH . '/middleware/AuthMiddleware.php';

$router = new Router();
$router->get('auth/login', 'AuthController', 'loginForm');
$router->post('auth/login', 'AuthController', 'login');
$router->get('auth/register', 'AuthController', 'registerForm');
$router->post('auth/register', 'AuthController', 'register');
$router->get('auth/logout', 'AuthController', 'logout');
$router->get('dashboard/index', 'DashboardController', 'index');
$router->dispatch();
