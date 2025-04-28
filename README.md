
**A simple, framework-free PHP project demonstrating secure OOP, MVC architecture, and modern best practices.**

This project focuses on how to build a clean, maintainable PHP application **without a full-stack framework**, using simple OOP, Composer for dependency management, and dependency injection for your database layer. It’s designed as a starter template you can fork and build upon—perfect for learning or as the foundation of your next PHP application.

---

## 🔍 Features

- **Plain PHP OOP** without a heavy framework  
- **MVC architecture**  
  - **Models** for data & business logic  
  - **Views** for presentation (plain PHP templates)  
  - **Controllers** for request handling & coordination  
- **Secure practices**  
  - PDO + prepared statements to prevent SQL injection  
  - CSRF token protection on all forms  
  - XSS-safe output via `htmlspecialchars()`  
- **Composer** for autoloading & single-purpose libraries  
  - Routing (SimpleRouter)  
  - Validation (Respect/Validation)  
  - Image uploads (Bulletproof)  
- **Dependency Injection** for database connections  
- **Folder structure** that clearly separates concerns  
- **Role-based user management** (admin, editor, user)  
- **Pagination**, **CRUD**, **SEO-friendly URLs**

---

## 🚀 Getting Started

### Requirements

- PHP 7.4+ with PDO & JSON extensions  
- MySQL / MariaDB  
- Composer  

### Installation

1. **Clone the repo**  
   ```bash
   git clone https://github.com/YOUR_USERNAME/your-repo.git
   cd your-repo
2. **Install dependencies**

   ```bash
composer install
    ```
3. **Configure environment**

```bash
cp .env.example .env
```
- Open .env and fill in your database credentials, app URL, etc.

3. **Set up the database**

sql
Copy
Edit
CREATE DATABASE mvc_app CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE mvc_app;

-- Users table
CREATE TABLE `users` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `role` ENUM('admin','editor','user') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB;

-- Articles table
CREATE TABLE `articles` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `content` TEXT NOT NULL,
  `author_id` INT UNSIGNED,
  `image_path` VARCHAR(255) DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`author_id`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB;
Set your web server’s document root to the public/ directory

**⚙️ Usage**
Home Page: GET / — paginated list of articles

View Article: GET /view/{id}

Create Article: GET|POST /create (auth required)

Edit Article: GET|POST /edit/{id} (author or admin)

Delete Article: POST /delete/{id} (author or admin)

User Management (admin only):

List users: GET /admin/users

Change role: GET|POST /user/role/edit/{id}

✨ Contributing
Fork this repository

Create your feature branch

bash
Copy
Edit
git checkout -b feature/YourFeature
Commit your changes

bash
Copy
Edit
git commit -m "Add awesome feature"
Push to the branch

bash
Copy
Edit
git push origin feature/YourFeature
Open a Pull Request

📄 License
This project is licensed under the MIT License.

Tip: This template demonstrates secure, framework-free PHP using MVC best practices. Feel free to swap in other single-purpose libraries (templating, validation, routing) while keeping the core structure and security intact.

Copy
Edit
