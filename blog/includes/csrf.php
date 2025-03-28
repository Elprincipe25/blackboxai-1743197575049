<?php
require_once __DIR__.'/config.php';

class CSRF {
    public static function generateToken(): string {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public static function validateToken(string $token): bool {
        if (empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
            return false;
        }
        return true;
    }

    public static function getTokenField(): string {
        return '<input type="hidden" name="csrf_token" value="'.self::generateToken().'">';
    }
}

// Initialize CSRF protection
session_start();