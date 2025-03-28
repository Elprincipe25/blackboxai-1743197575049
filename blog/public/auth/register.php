<?php
require_once __DIR__.'/../../includes/config.php';
require_once __DIR__.'/../../includes/auth.php';
require_once __DIR__.'/../../includes/middleware.php';

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /register');
    exit;
}

// Verify CSRF token
Middleware::csrf();

// Input validation and sanitization
$username = trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING));
$email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

// Validate inputs
$errors = [];

if (empty($username) || strlen($username) < 3) {
    $errors[] = 'username_invalid';
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'email_invalid';
}

if (strlen($password) < 8) {
    $errors[] = 'password_too_short';
}

if ($password !== $confirm_password) {
    $errors[] = 'passwords_mismatch';
}

// Redirect back with errors if any
if (!empty($errors)) {
    header('Location: /register?errors=' . urlencode(implode(',', $errors)));
    exit;
}

// Attempt registration
try {
    $success = $auth->register($username, $email, $password);
    
    if ($success) {
        // Auto-login after successful registration
        $user = $auth->login($email, $password);
        if ($user) {
            session_start();
            $_SESSION['user'] = $user;
            header('Location: /?welcome=1');
            exit;
        }
    }
} catch (PDOException $e) {
    // Handle duplicate username/email
    if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
        if (strpos($e->getMessage(), 'username') !== false) {
            header('Location: /register?error=username_taken');
            exit;
        } elseif (strpos($e->getMessage(), 'email') !== false) {
            header('Location: /register?error=email_taken');
            exit;
        }
    }
    error_log('Registration error: ' . $e->getMessage());
}

// Generic error fallback
header('Location: /register?error=registration_failed');
exit;