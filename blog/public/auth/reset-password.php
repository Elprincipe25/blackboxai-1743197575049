<?php
require_once __DIR__.'/../../includes/config.php';
require_once __DIR__.'/../../includes/auth.php';
require_once __DIR__.'/../../includes/middleware.php';

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /forgot-password');
    exit;
}

// Verify CSRF token
Middleware::csrf();

// Get and validate inputs
$token = $_POST['token'] ?? '';
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

// Validate password requirements
if (strlen($password) < 8) {
    header('Location: /reset-password?token='.urlencode($token).'&error=password_too_short');
    exit;
}

if ($password !== $confirm_password) {
    header('Location: /reset-password?token='.urlencode($token).'&error=passwords_mismatch');
    exit;
}

// Validate token and get user
$user = $auth->validateResetToken($token);

if (!$user) {
    header('Location: /forgot-password?error=invalid_or_expired_token');
    exit;
}

// Update password
try {
    $success = $auth->updatePassword($user['id'], $password);
    
    if ($success) {
        // Invalidate all existing sessions for security
        $stmt = $pdo->prepare("UPDATE users SET reset_token = NULL, reset_expires = NULL WHERE id = ?");
        $stmt->execute([$user['id']]);
        
        header('Location: /login?success=password_reset');
        exit;
    }
} catch (PDOException $e) {
    error_log('Password reset error: '.$e->getMessage());
}

// If we reach here, something went wrong
header('Location: /reset-password?token='.urlencode($token).'&error=reset_failed');
exit;