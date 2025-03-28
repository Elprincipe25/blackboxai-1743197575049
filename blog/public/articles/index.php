<?php
require_once __DIR__.'/../../includes/config.php';
require_once __DIR__.'/../../includes/ArticleController.php';

$pdo = require __DIR__.'/../../includes/config.php';
$articleController = new ArticleController($pdo);
$articles = $articleController->getRecentArticles(10);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Articles | <?= APP_NAME ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <?php include __DIR__.'/../../includes/nav.php'; ?>
    
    <div class="max-w-6xl mx-auto py-8 px-4">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold">Latest Articles</h1>
            <?php if (isset($_SESSION['user'])): ?>
                <a href="/articles/create" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                    <i class="fas fa-plus mr-2"></i> New Article
                </a>
            <?php endif; ?>
        </div>

        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            <?php foreach ($articles as $article): ?>
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                    <?php if ($article['image_path']): ?>
                        <img src="<?= htmlspecialchars($article['image_path']) ?>" alt="<?= htmlspecialchars($article['title']) ?>" class="w-full h-48 object-cover">
                    <?php endif; ?>
                    <div class="p-6">
                        <span class="inline-block px-3 py-1 bg-gray-200 text-gray-800 rounded-full text-xs font-semibold mb-2">
                            <?= htmlspecialchars($article['category']) ?>
                        </span>
                        <h2 class="text-xl font-bold mb-2">
                            <a href="/articles/<?= $article['id'] ?>" class="hover:text-blue-600 transition">
                                <?= htmlspecialchars($article['title']) ?>
                            </a>
                        </h2>
                        <p class="text-gray-600 text-sm mb-4">
                            By <?= htmlspecialchars($article['username']) ?> • 
                            <?= date('M j, Y', strtotime($article['created_at'])) ?>
                        </p>
                        <p class="text-gray-700 mb-4 line-clamp-3">
                            <?= substr(strip_tags($article['content']), 0, 200) ?>...
                        </p>
                        <div class="flex justify-between items-center">
                            <a href="/articles/<?= $article['id'] ?>" class="text-blue-600 hover:text-blue-800 transition">
                                Read More <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                            <?php if (isset($_SESSION['user']) && $_SESSION['user']['id'] == $article['user_id']): ?>
                                <div class="flex space-x-2">
                                    <a href="/articles/<?= $article['id'] ?>/edit" class="text-gray-600 hover:text-gray-900 transition">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="/articles/<?= $article['id'] ?>/delete" method="POST" class="inline">
                                        <?= CSRF::getTokenField() ?>
                                        <button type="submit" class="text-red-600 hover:text-red-900 transition" onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>