<?php
require_once __DIR__.'/../../includes/config.php';
require_once __DIR__.'/../../includes/auth.php';
require_once __DIR__.'/../../includes/middleware.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /login');
    exit;
}

// Verify CSRF token
Middleware::csrf();

$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$password = $_POST['password'] ?? '';
$remember = isset($_POST['remember']);

$user = $auth->login($email, $password);

if ($user) {
    // Start secure session
    session_start();
    $_SESSION['user'] = $user;
    
    // Set remember me cookie if requested
    if ($remember) {
        $token = bin2hex(random_bytes(32));
        $expires = time() + 60 * 60 * 24 * 30; // 30 days
        
        setcookie(
            'remember_token',
            $token,
            $expires,
            '/',
            '',
            true,  // Secure
            true   // HttpOnly
        );
        
        // Store token in database (implementation needed)
    }
    
    flash('success', 'You have been logged in successfully!');
    header('Location: /');
    exit;
} else {
    flash('error', 'Invalid email or password');
    header('Location: /login');
    exit;
}