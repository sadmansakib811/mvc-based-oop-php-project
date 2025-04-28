<?php include __DIR__ . '/header.php'; ?>
<h1>Login</h1>
<form method="post" action="/login">
    <label for="username">Username:</label>
    <input type="text" name="username" required>
    <br>
    <label for="password">Password:</label>
    <input type="password" name="password" required>
    <br>
    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
    <button type="submit">Login</button>
</form>
<?php include __DIR__ . '/footer.php'; ?>
