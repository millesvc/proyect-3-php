<?php
/**
 * Middleware de autenticación.
 * Compatible con PHP 7.3.
 */

class AuthMiddleware {
    public static function requireAuth() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (empty($_SESSION['user_id']) || empty($_SESSION['user_name'])) {
            $base = rtrim(BASE_URL, '/');
            header("Location: {$base}/?route=auth/login");
            exit;
        }
    }

    public static function redirectIfAuthenticated() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!empty($_SESSION['user_id'])) {
            $base = rtrim(BASE_URL, '/');
            header("Location: {$base}/?route=dashboard/index");
            exit;
        }
    }

    public static function userId() {
        return isset($_SESSION['user_id']) ? (int) $_SESSION['user_id'] : null;
    }

    public static function userName() {
        return isset($_SESSION['user_name']) ? $_SESSION['user_name'] : null;
    }
}
