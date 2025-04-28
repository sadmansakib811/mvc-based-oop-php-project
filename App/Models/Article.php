<?php
// app/models/Article.php

namespace App\Models;

use PDO;

class Article {
    private PDO $db;
    
    public function __construct(PDO $db) {
        $this->db = $db;
    }
    
    // Create a new article.
    public function create(array $data): bool {
        $stmt = $this->db->prepare("
            INSERT INTO articles (title, content, author_id, image_path)
            VALUES (:title, :content, :author_id, :image_path)
        ");
        return $stmt->execute([
            ':title' => $data['title'],
            ':content' => $data['content'],
            ':author_id' => $data['author_id'],
            ':image_path' => $data['image_path'] ?? null,
        ]);
    }
    
    // Update an article.
    public function update($id, array $data): bool {
        $stmt = $this->db->prepare("UPDATE articles SET title = :title, content = :content, image_path=:image_path
         WHERE id = :id");
        return $stmt->execute([
            ':title' => $data['title'],
            ':content' => $data['content'],
            ':image_path' => $data['image_path'] ?? null,
            ':id' => $id
        ]);
    }
    
    // Delete an article.
    public function delete($id): bool {
        $stmt = $this->db->prepare("DELETE FROM articles WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
    
    // Find an article by ID.
    public function findById($id) {
        $stmt = $this->db->prepare("
        SELECT a.*, u.username AS author 
        FROM articles a
        LEFT JOIN users u ON a.author_id = u.id 
        WHERE a.id = :id 
        LIMIT 1
    ");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }
    
    // Get paginated articles (also retrieving the author's username).
    public function getArticles($limit, $offset) {
        $stmt = $this->db->prepare(
            "SELECT a.*, u.username AS author 
             FROM articles a 
             LEFT JOIN users u ON a.author_id = u.id 
             ORDER BY a.id DESC 
             LIMIT :limit OFFSET :offset"
        );
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    // Count total articles.
    public function countArticles(): int {
        $stmt = $this->db->query("SELECT COUNT(*) as count FROM articles");
        $result = $stmt->fetch();
        return $result ? (int)$result['count'] : 0;
    }
}
