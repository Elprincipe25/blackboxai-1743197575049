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

// Handle image removal if requested
$image = null;
if (empty($_POST['remove_image']) && isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $image = $_FILES['image'];
}

try {
    $success = $articleController->updateArticle(
        $_GET['id'],
        $_POST,
        $image
    );
    
    if ($success) {
        header('Location: /articles/' . $_GET['id'] . '?success=updated');
    } else {
        header('Location: /articles/' . $_GET['id'] . '/edit?error=update_failed');
    }
} catch (Exception $e) {
    error_log('Article update error: ' . $e->getMessage());
    header('Location: /articles/' . $_GET['id'] . '/edit?error=server_error');
}
exit;