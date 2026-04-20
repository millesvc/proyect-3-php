<?php
/**
 * AuthController.
 * Compatible con PHP 7.3.
 */

require_once BASE_PATH . '/core/Controller.php';
require_once BASE_PATH . '/models/User.php';
require_once BASE_PATH . '/middleware/AuthMiddleware.php';

class AuthController extends Controller {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function loginForm() {
        AuthMiddleware::redirectIfAuthenticated();
        $this->render('login');
    }

    public function login() {
        AuthMiddleware::redirectIfAuthenticated();

        $email = $this->post('email');
        $password = $this->post('password');
        $errors = $this->validateLogin($email, $password);

        if (!empty($errors)) {
            $this->render('login', array(
                'errors' => $errors,
                'old_email' => $this->sanitize($email),
            ));
            return;
        }

        $user = $this->userModel->findByEmail($email);

        if (!$user || !$this->userModel->verifyPassword($password, $user['password'])) {
            $this->render('login', array(
                'errors' => array('Credenciales incorrectas. Verifica tu email y contraseña.'),
                'old_email' => $this->sanitize($email),
            ));
            return;
        }

        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];

        $this->redirect('/?route=dashboard/index');
    }

    public function registerForm() {
        AuthMiddleware::redirectIfAuthenticated();
        $this->render('register');
    }

    public function register() {
        AuthMiddleware::redirectIfAuthenticated();

        $name = $this->post('name');
        $email = $this->post('email');
        $password = $this->post('password');
        $confirm = $this->post('password_confirm');

        $errors = $this->validateRegister($name, $email, $password, $confirm);

        if (!empty($errors)) {
            $this->render('register', array(
                'errors' => $errors,
                'old_name' => $this->sanitize($name),
                'old_email' => $this->sanitize($email),
            ));
            return;
        }

        if ($this->userModel->emailExists($email)) {
            $this->render('register', array(
                'errors' => array('Este email ya está registrado. ¿Deseas iniciar sesión?'),
                'old_name' => $this->sanitize($name),
                'old_email' => $this->sanitize($email),
            ));
            return;
        }

        $created = $this->userModel->create($name, $email, $password);

        if (!$created) {
            $this->render('register', array(
                'errors' => array('Error al crear la cuenta. Inténtalo de nuevo.'),
                'old_name' => $this->sanitize($name),
                'old_email' => $this->sanitize($email),
            ));
            return;
        }

        $_SESSION['flash_success'] = '¡Cuenta creada exitosamente! Ahora puedes iniciar sesión.';
        $this->redirect('/?route=auth/login');
    }

    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION = array();

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }

        session_destroy();
        $this->redirect('/?route=auth/login');
    }

    private function validateLogin($email, $password) {
        $errors = array();

        if (empty($email)) {
            $errors[] = 'El email es requerido.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'El formato del email no es válido.';
        }

        if (empty($password)) {
            $errors[] = 'La contraseña es requerida.';
        }

        return $errors;
    }

    private function validateRegister($name, $email, $password, $confirm) {
        $errors = array();

        if (empty($name)) {
            $errors[] = 'El nombre es requerido.';
        } elseif (strlen($name) < 2 || strlen($name) > 100) {
            $errors[] = 'El nombre debe tener entre 2 y 100 caracteres.';
        } elseif (!preg_match("/^[\p{L}\s'-]+$/u", $name)) {
            $errors[] = 'El nombre solo puede contener letras, espacios, guiones y apóstrofes.';
        }

        if (empty($email)) {
            $errors[] = 'El email es requerido.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'El formato del email no es válido.';
        } elseif (strlen($email) > 255) {
            $errors[] = 'El email es demasiado largo.';
        }

        if (empty($password)) {
            $errors[] = 'La contraseña es requerida.';
        } elseif (strlen($password) < 8) {
            $errors[] = 'La contraseña debe tener al menos 8 caracteres.';
        } elseif (!preg_match('/[A-Z]/', $password)) {
            $errors[] = 'La contraseña debe contener al menos una letra mayúscula.';
        } elseif (!preg_match('/[0-9]/', $password)) {
            $errors[] = 'La contraseña debe contener al menos un número.';
        }

        if (empty($confirm)) {
            $errors[] = 'Confirma tu contraseña.';
        } elseif ($password !== $confirm) {
            $errors[] = 'Las contraseñas no coinciden.';
        }

        return $errors;
    }
}
