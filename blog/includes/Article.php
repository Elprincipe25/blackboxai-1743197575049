<?php
require_once __DIR__.'/config.php';

class Article {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function create(int $userId, string $title, string $content, ?string $imagePath = null, string $category = 'General'): bool {
        $stmt = $this->pdo->prepare("INSERT INTO articles (user_id, title, content, image_path, category) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$userId, $title, $content, $imagePath, $category]);
    }

    public function update(int $id, int $userId, string $title, string $content, ?string $imagePath = null, string $category = 'General'): bool {
        $stmt = $this->pdo->prepare("UPDATE articles SET title = ?, content = ?, image_path = ?, category = ? WHERE id = ? AND user_id = ?");
        return $stmt->execute([$title, $content, $imagePath, $category, $id, $userId]);
    }

    public function delete(int $id, int $userId): bool {
        $stmt = $this->pdo->prepare("DELETE FROM articles WHERE id = ? AND user_id = ?");
        return $stmt->execute([$id, $userId]);
    }

    public function getById(int $id): ?array {
        $stmt = $this->pdo->prepare("SELECT a.*, u.username FROM articles a JOIN users u ON a.user_id = u.id WHERE a.id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function getAll(int $limit = 10, int $offset = 0): array {
        $stmt = $this->pdo->prepare("SELECT a.*, u.username FROM articles a JOIN users u ON a.user_id = u.id ORDER BY a.created_at DESC LIMIT ? OFFSET ?");
        $stmt->execute([$limit, $offset]);
        return $stmt->fetchAll();
    }

    public function getByUser(int $userId, int $limit = 10, int $offset = 0): array {
        $stmt = $this->pdo->prepare("SELECT * FROM articles WHERE user_id = ? ORDER BY created_at DESC LIMIT ? OFFSET ?");
        $stmt->execute([$userId, $limit, $offset]);
        return $stmt->fetchAll();
    }

    public function getByCategory(string $category, int $limit = 10, int $offset = 0): array {
        $stmt = $this->pdo->prepare("SELECT a.*, u.username FROM articles a JOIN users u ON a.user_id = u.id WHERE a.category = ? ORDER BY a.created_at DESC LIMIT ? OFFSET ?");
        $stmt->execute([$category, $limit, $offset]);
        return $stmt->fetchAll();
    }
}