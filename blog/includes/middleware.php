<?php
require_once __DIR__.'/csrf.php';
require_once __DIR__.'/auth.php';

class Middleware {
    public static function csrf(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_POST['csrf_token'] ?? '';
            if (!CSRF::validateToken($token)) {
                error_log('CSRF validation failed for: ' . $_SERVER['REQUEST_URI']);
                http_response_code(403);
                include __DIR__.'/../public/errors/403.php';
                exit;
            }
        }
    }

    public static function auth(): void {
        session_start();
        if (empty($_SESSION['user'])) {
            $_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];
            header('Location: /login');
            exit;
        }
    }

    public static function guest(): void {
        session_start();
        if (!empty($_SESSION['user'])) {
            header('Location: /');
            exit;
        }
    }

    public static function admin(): void {
        self::auth();
        if ($_SESSION['user']['role'] !== 'admin') {
            http_response_code(403);
            include __DIR__.'/../public/errors/403.php';
            exit;
        }
    }
}