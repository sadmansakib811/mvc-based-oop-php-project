<?php include __DIR__ . '/header.php'; ?>

<h1>Manage Users</h1>

<?php if (!empty($users)): ?>
    <table border="1" cellspacing="0" cellpadding="8">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= htmlspecialchars($user['id']); ?></td>
                <td><?= htmlspecialchars($user['username']); ?></td>
                <td><?= htmlspecialchars($user['role']); ?></td>
                <td>
                    <!-- Link to the role editing page -->
                    <a href="/editRole/<?= htmlspecialchars($user['id']); ?>">Change Role</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No users found.</p>
<?php endif; ?>

<?php include __DIR__ . '/footer.php'; ?>
