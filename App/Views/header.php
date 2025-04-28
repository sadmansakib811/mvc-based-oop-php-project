<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My MVC Project</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<nav>
    <a href="/">Home</a>
   
    <?php if(isset($_SESSION['user'])): ?>
        <?php if($_SESSION['user']['role'] == 'admin'): ?>
                      <a href="/admin/users">Manage Users</a>
                    <?php endif; ?> 
        <span>Welcome, <?= htmlspecialchars($_SESSION['user']['username']); ?></span>
        <a href="/create">Create Article</a>
        <a href="/logout">Logout</a>
    <?php else: ?>
        <a href="/login">Login</a>
<a href="/signup">Sign Up</a>

    <?php endif; ?>
</nav>
<hr>
