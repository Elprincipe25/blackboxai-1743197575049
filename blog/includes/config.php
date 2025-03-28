<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'blog_app');
define('DB_USER', 'root'); 
define('DB_PASS', '');

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Session configuration
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1);
ini_set('session.use_strict_mode', 1);

// Establish PDO connection
try {
    $pdo = new PDO(
        "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// OAuth Providers Configuration
define('OAUTH_CONFIG', [
    'google' => [
        'client_id' => 'YOUR_GOOGLE_CLIENT_ID',
        'client_secret' => 'YOUR_GOOGLE_SECRET',
        'redirect_uri' => 'http://localhost:8000/auth/google/callback'
    ],
    'github' => [
        'client_id' => 'YOUR_GITHUB_CLIENT_ID',
        'client_secret' => 'YOUR_GITHUB_SECRET',
        'redirect_uri' => 'http://localhost:8000/auth/github/callback'
    ]
]);

// Application constants
define('APP_NAME', 'Modern Blog');
define('BASE_URL', 'http://localhost:8000');
define('UPLOAD_DIR', __DIR__ . '/../uploads');