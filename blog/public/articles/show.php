<?php
require_once __DIR__.'/../../includes/config.php';
require_once __DIR__.'/../../includes/ArticleController.php';

$pdo = require __DIR__.'/../../includes/config.php';
$articleController = new ArticleController($pdo);

if (!isset($_GET['id']) || !$article = $articleController->getArticle($_GET['id'])) {
    header('Location: /errors/404.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($article['title']) ?> | <?= APP_NAME ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <?php include __DIR__.'/../../includes/nav.php'; ?>
    
    <div class="max-w-4xl mx-auto py-8 px-4">
        <article class="bg-white p-8 rounded-lg shadow-md">
            <?php if ($article['image_path']): ?>
                <img src="<?= htmlspecialchars($article['image_path']) ?>" alt="<?= htmlspecialchars($article['title']) ?>" class="w-full h-96 object-cover rounded-lg mb-6">
            <?php endif; ?>
            
            <div class="flex items-center mb-6">
                <span class="px-3 py-1 bg-gray-200 text-gray-800 rounded-full text-xs font-semibold mr-4">
                    <?= htmlspecialchars($article['category']) ?>
                </span>
                <span class="text-gray-600 text-sm">
                    By <?= htmlspecialchars($article['username']) ?> • 
                    <?= date('F j, Y', strtotime($article['created_at'])) ?>
                </span>
            </div>
            
            <h1 class="text-3xl font-bold mb-6"><?= htmlspecialchars($article['title']) ?></h1>
            
            <div class="prose max-w-none mb-8">
                <?= $article['content'] ?>
            </div>
            
            <?php if (isset($_SESSION['user']) && $_SESSION['user']['id'] == $article['user_id']): ?>
                <div class="flex space-x-4 border-t pt-6">
                    <a href="/articles/<?= $article['id'] ?>/edit" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition">
                        <i class="fas fa-edit mr-2"></i> Edit
                    </a>
                    <form action="/articles/<?= $article['id'] ?>/delete" method="POST" class="inline">
                        <?= CSRF::getTokenField() ?>
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition" onclick="return confirm('Are you sure you want to delete this article?')">
                            <i class="fas fa-trash mr-2"></i> Delete
                        </button>
                    </form>
                </div>
            <?php endif; ?>
        </article>

        <!-- Comments Section -->
        <div class="mt-12 bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold mb-6">Comments</h2>
            <form action="/comments" method="POST" class="mb-8">
                <?= CSRF::getTokenField() ?>
                <input type="hidden" name="article_id" value="<?= $article['id'] ?>">
                <div class="mb-4">
                    <textarea name="content" rows="3" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Share your thoughts..."></textarea>
                </div>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                    Post Comment
                </button>
            </form>

            <div class="space-y-6">
                <!-- Sample Comment - In a real app, these would come from database -->
                <div class="border-b pb-6">
                    <div class="flex items-center mb-2">
                        <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center mr-3">
                            <i class="fas fa-user text-gray-500"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold">John Doe</h3>
                            <p class="text-gray-500 text-sm">2 days ago</p>
                        </div>
                    </div>
                    <p class="text-gray-700 ml-13">This is a great article! Very informative.</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>