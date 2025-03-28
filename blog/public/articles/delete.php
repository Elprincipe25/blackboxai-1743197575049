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

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_GET['id'])) {
    header('Location: /articles');
    exit;
}

try {
    $success = $articleController->deleteArticle($_GET['id']);
    
    if ($success) {
        header('Location: /articles?success=deleted');
    } else {
        header('Location: /articles/' . $_GET['id'] . '?error=delete_failed');
    }
} catch (Exception $e) {
    error_log('Article deletion error: ' . $e->getMessage());
    header('Location: /articles/' . $_GET['id'] . '?error=server_error');
}
exit;