<?php
require_once __DIR__.'/config.php';
require_once __DIR__.'/Article.php';
require_once __DIR__.'/auth.php';
require_once __DIR__.'/middleware.php';

class ArticleController {
    private $article;
    private $auth;

    public function __construct(PDO $pdo) {
        $this->article = new Article($pdo);
        $this->auth = new Auth($pdo);
    }

    public function createArticle(array $data, array $file = null): bool {
        session_start();
        if (!isset($_SESSION['user'])) {
            return false;
        }

        $userId = $_SESSION['user']['id'];
        $title = filter_var($data['title'], FILTER_SANITIZE_STRING);
        $content = filter_var($data['content'], FILTER_SANITIZE_STRING);
        $category = filter_var($data['category'] ?? 'General', FILTER_SANITIZE_STRING);
        $imagePath = $this->handleImageUpload($file);

        return $this->article->create($userId, $title, $content, $imagePath, $category);
    }

    public function updateArticle(int $id, array $data, array $file = null): bool {
        session_start();
        if (!isset($_SESSION['user'])) {
            return false;
        }

        $userId = $_SESSION['user']['id'];
        $title = filter_var($data['title'], FILTER_SANITIZE_STRING);
        $content = filter_var($data['content'], FILTER_SANITIZE_STRING);
        $category = filter_var($data['category'] ?? 'General', FILTER_SANITIZE_STRING);
        $imagePath = $this->handleImageUpload($file);

        return $this->article->update($id, $userId, $title, $content, $imagePath, $category);
    }

    public function deleteArticle(int $id): bool {
        session_start();
        if (!isset($_SESSION['user'])) {
            return false;
        }

        return $this->article->delete($id, $_SESSION['user']['id']);
    }

    private function handleImageUpload(?array $file): ?string {
        if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        $validTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($file['type'], $validTypes)) {
            return null;
        }

        $uploadDir = __DIR__.'/../uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid().'.'.$extension;
        $destination = $uploadDir.$filename;

        if (move_uploaded_file($file['tmp_name'], $destination)) {
            return '/uploads/'.$filename;
        }

        return null;
    }

    public function getArticle(int $id): ?array {
        return $this->article->getById($id);
    }

    public function getRecentArticles(int $limit = 10): array {
        return $this->article->getAll($limit);
    }

    public function getUserArticles(int $userId, int $limit = 10): array {
        return $this->article->getByUser($userId, $limit);
    }

    public function getArticlesByCategory(string $category, int $limit = 10): array {
        return $this->article->getByCategory($category, $limit);
    }
}