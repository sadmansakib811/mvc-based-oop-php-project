<?php
// app/controllers/ArticleController.php

namespace App\Controllers;

use App\Config\Database;
use App\Models\Article;
use Respect\Validation\Validator as v;
use Bulletproof\Image; 
class ArticleController {
    
    public function view($id) {
        $db = Database::getConnection();
        $articleModel = new Article($db);
        $article = $articleModel->findById($id);
        if (!$article) {
            die("Article not found.");
        }
        include __DIR__ . '/../Views/view.php';
    }
    
    public function create() {
        // Only logged-in users can create articles.
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit();
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            echo "<pre>";
            print_r($_FILES);
            echo "</pre>";
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                die("Invalid CSRF token.");
            }
            $title = trim($_POST['title'] ?? '');
            $content = trim($_POST['content'] ?? '');
            
            // Validate title and content.
            $titleValidator = v::stringType()->length(5, 100);
            $contentValidator = v::stringType()->length(10, null);
            if (!$titleValidator->validate($title) || !$contentValidator->validate($content)) {
                die("Invalid input. Check your title and content.");
            }
           // Process image upload using Bulletproof.
           $image = new Image($_FILES);
           // Set the storage path for uploaded images.
           $image->setStorage(__DIR__ . '/../../public/uploads');
           $image->setSize(1, 50000000);
           $image->setDimension(50000, 50000);
           if ($image["pictures"]) {
            $upload = $image->upload();  // Using the default documented usage.
            if ($upload) {
                // Get only the file name from the full path.
                $filename = basename($upload->getPath());
                // Build the relative path – we know our images are stored in "uploads/".
                $imagePath = 'uploads/' . $filename;
            } else {
                die("Image upload failed: " . $image->getError());
            }
        } else {
            $imagePath = null;
        }
        
            $db = Database::getConnection();
            $articleModel = new Article($db);
            $authorId = $_SESSION['user']['id'];
            
            $success = $articleModel->create([
                'title' => $title,
                'content' => $content,
                'author_id' => $authorId,
                'image_path' => $imagePath
            ]);
            
            if ($success) {
                header("Location: /");
                exit();
            } else {
                die("Failed to create the article.");
            }
        } else {
            include __DIR__ . '/../Views/create.php';
        }
    }
    
    public function edit($id) {
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit();
        }
        $db = Database::getConnection();
        $articleModel = new Article($db);
        $article = $articleModel->findById($id);
        if (!$article) {
            die("Article not found.");
        }
        // Check if the current user is the author or an admin.
        if ($_SESSION['user']['id'] != $article['author_id'] && $_SESSION['user']['role'] !== 'admin') {
            die("Access denied.");
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                die("Invalid CSRF token.");
            }
            $title = trim($_POST['title'] ?? '');
            $content = trim($_POST['content'] ?? '');
            
            $titleValidator = v::stringType()->length(5, 100);
            $contentValidator = v::stringType()->length(10, null);
            if (!$titleValidator->validate($title) || !$contentValidator->validate($content)) {
                die("Invalid input.");
            }
            
            // Process new image upload if provided.
            $image = new Image($_FILES);
            $image->setStorage(__DIR__ . '/../../public/uploads');
            $image->setSize(1, 50000000);
           $image->setDimension(50000, 50000);
           if ($image["pictures"] && !empty($_FILES["pictures"]["name"])) {
            $upload = $image->upload();
            if ($upload) {
                // Use basename() to extract the filename.
                $filename = basename($upload->getPath());
                // Prepend the directory ("uploads/") to make a relative URL.
                $imagePath = 'uploads/' . $filename;
            } else {
                die("Image upload failed: " . $image->getError());
            }
        }
        
        
            
            
            $success = $articleModel->update($id, [
                'title' => $title,
                'content' => $content,
                'image_path'=>$imagePath 
            ]);
            
            if ($success) {
                header("Location: /view/$id");
                exit();
            } else {
                die("Failed to update the article.");
            }
        } else {
            include __DIR__ . '/../views/edit.php';
        }
    }
    
    public function delete($id) {
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit();
        }
        $db = Database::getConnection();
        $articleModel = new Article($db);
        $article = $articleModel->findById($id);
        if (!$article) {
            die("Article not found.");
        }
        if ($_SESSION['user']['id'] != $article['author_id'] && $_SESSION['user']['role'] !== 'admin') {
            die("Access denied.");
        }
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            die("Invalid CSRF token.");
        }
        $success = $articleModel->delete($id);
        if ($success) {
            header("Location: /");
            exit();
        } else {
            die("Failed to delete the article.");
        }
    }
}
