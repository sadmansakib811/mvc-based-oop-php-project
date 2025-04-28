<?php include __DIR__ . '/header.php'; ?>
<h1><?= htmlspecialchars($article['title']); ?></h1>
<?php if (!empty($article['image_path'])): ?>
    <div>
        <img src="/<?= htmlspecialchars($article['image_path']); ?>" alt="Image for <?= htmlspecialchars($article['title']); ?>">
    </div>
<?php endif; ?>
<p>By: <?= htmlspecialchars($article['author']); ?></p>
<p><?= nl2br(htmlspecialchars($article['content'])); ?></p>
<?php if (isset($_SESSION['user']) && ($_SESSION['user']['id'] == $article['author_id'] || $_SESSION['user']['role'] === 'admin')): ?>
    <a href="/edit/<?= htmlspecialchars($article['id']); ?>">Edit</a>
    <form method="post" action="/delete/<?= htmlspecialchars($article['id']); ?>" style="display:inline;">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
        <button type="submit">Delete</button>
    </form>
<?php endif; ?>
<?php include __DIR__ . '/footer.php'; ?>
