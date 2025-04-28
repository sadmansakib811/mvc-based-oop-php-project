<?php
// app/controllers/UserController.php

namespace App\Controllers;

use App\Config\Database;
use App\Models\User;
use Respect\Validation\Validator as v;

class UserController {
    
    public function loginForm() {
        include __DIR__ . '/../views/login.php';
    }
    
    public function login() {
        // CSRF check using session token.
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            die("Invalid CSRF token.");
        }
        
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        
        // Validate input.
        $usernameValidator = v::alnum()->noWhitespace()->length(3, 20);
        $passwordValidator = v::length(6, 30);
        if (!$usernameValidator->validate($username) || !$passwordValidator->validate($password)) {
            die("Invalid input.");
        }
        
        $db = Database::getConnection();
        $userModel = new User($db);
        $user = $userModel->findByUsername($username);
        
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
            header("Location: /");
            exit();
        } else {
            die("Authentication failed.");
        }
    }
    
    public function signupForm() {
        include __DIR__ . '/../views/signup.php';
    }
    
    public function signup() {
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            die("Invalid CSRF token.");
        }
        
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        
        // Validate inputs.
        $usernameValidator = v::alnum()->noWhitespace()->length(3, 20);
        $passwordValidator = v::length(6, 30);
        if (!$usernameValidator->validate($username) || !$passwordValidator->validate($password)) {
            die("Invalid input.");
        }
        
        $db = Database::getConnection();
        $userModel = new User($db);
        if ($userModel->findByUsername($username)) {
            die("Username already exists.");
        }
        
        // Register the new user; default role is "user".
        $success = $userModel->create([
            'username' => $username,
            'password' => $password,  // Model uses password_hash() internally
            'role' => 'user'
        ]);
        
        if ($success) {
            header("Location: /login");
            exit();
        } else {
            die("Registration failed.");
        }
    }
    public function editRole($id) {
        // Allow only administrators to change roles.
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            die("Access denied. Only administrators may change user roles.");
        }
        
        $db = \App\Config\Database::getConnection();
        $userModel = new User($db);
        $user = $userModel->findById($id);
        if (!$user) {
            die("User not found.");
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Check CSRF token.
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                die("Invalid CSRF token.");
            }
            
            // Retrieve the new role from the form.
            $role = trim($_POST['role'] ?? '');
            // Validate that the role is one of the allowed values.
            if (!in_array($role, ['admin', 'editor', 'user'])) {
                die("Invalid role selected.");
            }
            
            // Update the user's role.
            $success = $userModel->updateRole($id, $role);
            if ($success) {
                header("Location: /admin/users");  // Or redirect to a listing page
                exit();
            } else {
                die("Failed to update the user role.");
            }
        } else {
            // On GET, display the form.
            include __DIR__ . '/../views/editUserRole.php';
        }
    }
    public function adminUserList() {
        // Only allow admin access.
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            die("Access denied. Only administrators can view this page.");
        }
        
        $db = Database::getConnection();
        $userModel = new User($db);
        // Assuming you have a method getAllUsers() in the User model.
        $users = $userModel->getAllUsers();
        
        include __DIR__ . '/../Views/adminUsers.php';
    }
    
    public function logout() {
        unset($_SESSION['user']);
        header("Location: /");
        exit();
    }
}
