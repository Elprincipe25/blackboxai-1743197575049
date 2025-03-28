<?php
require_once __DIR__.'/../../includes/config.php';
require_once __DIR__.'/../../includes/auth.php';
require_once __DIR__.'/../../includes/middleware.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /forgot-password');
    exit;
}

// Verify CSRF token
Middleware::csrf();

$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: /forgot-password?error=invalid_email');
    exit;
}

// Check if email exists in database
$stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();

if ($user) {
    // Generate and store reset token
    $token = $auth->createResetToken($email);
    
    if ($token) {
        // In a real application, send email with reset link
        // $resetLink = BASE_URL . "/reset-password?token=" . urlencode($token);
        // mail($email, "Password Reset", "Click here to reset: " . $resetLink);
        
        // For development, we'll log the token
        error_log("Password reset token for $email: $token");
    }
}

// Always show success message to prevent email enumeration
header('Location: /forgot-password?success=1');
exit;