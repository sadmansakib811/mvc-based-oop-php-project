<?php
// app/config/Database.php

namespace App\Config;

use PDO;
use PDOException;

class Database {
    private static ?PDO $instance = null;

    public static function getConnection(): PDO {
        if (self::$instance === null) {
            // Update DSN, username, and password per your environment
            // $dsn = 'mysql:host=localhost;dbname=mvc1';
            // $username = 'root';
            // $password = '';

            $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
            $username = DB_USER;
            $password = DB_PASS;

            try {
                self::$instance = new PDO($dsn, $username, $password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]);
            } catch (PDOException $e) {
                die("Database connection failed: " . $e->getMessage());
            }
        }
        return self::$instance;
    }
}
