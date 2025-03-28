<?php
require_once __DIR__.'/../includes/config.php';
require_once __DIR__.'/../includes/middleware.php';
require_once __DIR__.'/../includes/csrf.php';

session_start();
Middleware::csrf();

// Destroy all session data
$_SESSION = [];
session_destroy();

// Clear remember me cookie if set
if (isset($_COOKIE['remember_token'])) {
    setcookie('remember_token', '', time() - 3600, '/');
}

// Redirect to login page
header('Location: /login?success=logged_out');
exit;