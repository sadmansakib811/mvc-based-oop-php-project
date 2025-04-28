<?php include __DIR__ . '/header.php'; ?>
<h1>Edit User Role</h1>
<form method="post" action="/editRole/<?= htmlspecialchars($user['id']); ?>">
    <label for="role">Select Role:</label>
    <select name="role" id="role" required>
        <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
        <option value="editor" <?= $user['role'] === 'editor' ? 'selected' : ''; ?>>Editor</option>
        <option value="user" <?= $user['role'] === 'user' ? 'selected' : ''; ?>>User</option>
    </select>
    <br>
    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
    <button type="submit">Update Role</button>
</form>
<?php include __DIR__ . '/footer.php'; ?>
