<?php
// app/controllers/HomeController.php

namespace App\Controllers;

use App\Config\Database;
use App\Models\Article;

class HomeController {
    public function index() {
        $db = Database::getConnection();
        $articleModel = new Article($db);
        
        // Set pagination: 5 articles per page.
        $limit = 5;
        $page = isset($_GET['page']) ? max((int)$_GET['page'], 1) : 1;
        $offset = ($page - 1) * $limit;
        
        // Fetch articles and total count.
        $articles = $articleModel->getArticles($limit, $offset);
        $totalArticles = $articleModel->countArticles();
        $totalPages = ceil($totalArticles / $limit);
        
    
        include __DIR__ . '/../views/home.php';
    }
}
