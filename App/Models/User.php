<?php
// app/models/User.php

namespace App\Models;

use PDO;

class User {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }
    public function getAllUsers(): array {
        $stmt = $this->db->query("SELECT * FROM users ORDER BY id ASC");
        return $stmt->fetchAll();
    }

    public function updateRole($id, $role): bool {
        $stmt = $this->db->prepare("UPDATE users SET role = :role WHERE id = :id");
        return $stmt->execute([
            ':role' => $role,
            ':id'   => $id
        ]);
    }
    
    
    // Find a user by username.
    public function findByUsername($username) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
        $stmt->execute([':username' => $username]);
        return $stmt->fetch();
    }
    
    // Create a new user with secure password storage.
    public function create(array $data): bool {
        $stmt = $this->db->prepare("INSERT INTO users (username, password, role)
         VALUES (:username, :password, :role)");
        return $stmt->execute([
            ':username' => $data['username'],
            ':password' => password_hash($data['password'], PASSWORD_DEFAULT),
            ':role'     => $data['role'] ?? 'user'
        ]);
    }
}