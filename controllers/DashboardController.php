<?php
/**
 * DashboardController.
 * Compatible con PHP 7.3.
 */

require_once BASE_PATH . '/core/Controller.php';
require_once BASE_PATH . '/models/User.php';
require_once BASE_PATH . '/middleware/AuthMiddleware.php';

class DashboardController extends Controller {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function index() {
        AuthMiddleware::requireAuth();

        $userId = AuthMiddleware::userId();
        $user = $this->userModel->findById($userId);

        if (!$user) {
            session_destroy();
            $this->redirect('/?route=auth/login');
            return;
        }

        $this->render('dashboard', array('user' => $user));
    }
}
