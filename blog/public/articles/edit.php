<?php
require_once __DIR__.'/../../includes/config.php';
require_once __DIR__.'/../../includes/ArticleController.php';
require_once __DIR__.'/../../includes/middleware.php';
require_once __DIR__.'/../../includes/csrf.php';

session_start();
Middleware::auth();

$pdo = require __DIR__.'/../../includes/config.php';
$articleController = new ArticleController($pdo);

if (!isset($_GET['id']) || !$article = $articleController->getArticle($_GET['id'])) {
    header('Location: /errors/404.php');
    exit;
}

// Verify article ownership
if ($_SESSION['user']['id'] !== $article['user_id']) {
    header('Location: /errors/403.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Article | <?= APP_NAME ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
</head>
<body class="bg-gray-100">
    <?php include __DIR__.'/../../includes/nav.php'; ?>
    
    <div class="max-w-4xl mx-auto py-8 px-4">
        <h1 class="text-3xl font-bold mb-6">Edit Article</h1>
        
        <form action="/articles/<?= $article['id'] ?>/update" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md">
            <?= CSRF::getTokenField() ?>
            
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                <input type="text" id="title" name="title" value="<?= htmlspecialchars($article['title']) ?>" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            <div class="mb-4">
                <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                <select id="category" name="category" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                    <option value="Technology" <?= $article['category'] === 'Technology' ? 'selected' : '' ?>>Technology</option>
                    <option value="Business" <?= $article['category'] === 'Business' ? 'selected' : '' ?>>Business</option>
                    <option value="Science" <?= $article['category'] === 'Science' ? 'selected' : '' ?>>Science</option>
                    <option value="Health" <?= $article['category'] === 'Health' ? 'selected' : '' ?>>Health</option>
                    <option value="Entertainment" <?= $article['category'] === 'Entertainment' ? 'selected' : '' ?>>Entertainment</option>
                </select>
            </div>
            
            <?php if ($article['image_path']): ?>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Current Image</label>
                    <img src="<?= htmlspecialchars($article['image_path']) ?>" alt="Current article image" class="h-48 object-cover rounded-md">
                    <div class="mt-2 flex items-center">
                        <input type="checkbox" id="remove_image" name="remove_image" class="mr-2">
                        <label for="remove_image" class="text-sm text-gray-700">Remove current image</label>
                    </div>
                </div>
            <?php endif; ?>
            
            <div class="mb-4">
                <label for="image" class="block text-sm font-medium text-gray-700 mb-1"><?= $article['image_path'] ? 'Replace Image' : 'Add Image' ?></label>
                <input type="file" id="image" name="image" accept="image/*"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            <div class="mb-4">
                <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Content</label>
                <textarea id="content" name="content" rows="10" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"><?= htmlspecialchars($article['content']) ?></textarea>
                <script>
                    CKEDITOR.replace('content');
                </script>
            </div>
            
            <div class="flex justify-end space-x-4">
                <a href="/articles/<?= $article['id'] ?>" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition">Cancel</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">Update Article</button>
            </div>
        </form>
    </div>
</body>
</html>