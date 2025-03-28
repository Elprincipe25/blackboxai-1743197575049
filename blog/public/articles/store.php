<?php
require_once __DIR__.'/../../includes/config.php';
require_once __DIR__.'/../../includes/ArticleController.php';
require_once __DIR__.'/../../includes/middleware.php';
require_once __DIR__.'/../../includes/csrf.php';

session_start();
Middleware::auth();
Middleware::csrf();

$pdo = require __DIR__.'/../../includes/config.php';
$articleController = new ArticleController($pdo);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /articles/create');
    exit;
}

try {
    $success = $articleController->createArticle($_POST, $_FILES['image'] ?? null);
    
    if ($success) {
        header('Location: /articles?success=created');
    } else {
        header('Location: /articles/create?error=creation_failed');
    }
} catch (Exception $e) {
    error_log('Article creation error: ' . $e->getMessage());
    header('Location: /articles/create?error=server_error');
}
exit;