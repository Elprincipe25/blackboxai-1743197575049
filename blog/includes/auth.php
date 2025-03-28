<?php
require_once __DIR__.'/config.php';

class Auth {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    // User registration
    public function register(string $username, string $email, string $password): bool {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->pdo->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");
        return $stmt->execute([$username, $email, $hashedPassword]);
    }

    // User login
    public function login(string $email, string $password): ?array {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            unset($user['password_hash']);
            return $user;
        }
        return null;
    }

    // Password reset
    public function createResetToken(string $email): ?string {
        $token = bin2hex(random_bytes(32));
        $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
        
        $stmt = $this->pdo->prepare("UPDATE users SET reset_token = ?, reset_expires = ? WHERE email = ?");
        if ($stmt->execute([$token, $expires, $email])) {
            return $token;
        }
        return null;
    }

    // Validate reset token
    public function validateResetToken(string $token): ?array {
        $stmt = $this->pdo->prepare("SELECT id, email FROM users WHERE reset_token = ? AND reset_expires > NOW()");
        $stmt->execute([$token]);
        return $stmt->fetch() ?: null;
    }

    // Update password
    public function updatePassword(int $userId, string $newPassword): bool {
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
        $stmt = $this->pdo->prepare("UPDATE users SET password_hash = ?, reset_token = NULL, reset_expires = NULL WHERE id = ?");
        return $stmt->execute([$hashedPassword, $userId]);
    }
}

// Initialize auth system
$auth = new Auth($pdo);