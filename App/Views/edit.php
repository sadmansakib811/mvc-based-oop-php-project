<?php include __DIR__ . '/header.php'; ?>
<h1>Edit Article</h1>
<form method="post" action="/edit/<?= htmlspecialchars($article['id']); ?>" enctype="multipart/form-data">
    <label for="title">Title:</label>
    <input type="text" name="title" value="<?= htmlspecialchars($article['title']); ?>" required>
    <br>
    <label for="content">Content:</label>
    <textarea name="content" rows="10" cols="50" required><?= htmlspecialchars($article['content']); ?></textarea>
    <br>
    <br>
    <?php if (!empty($article['image_path'])): ?>
        <div>
            <p>Current Image:</p>
            <img src="/<?= htmlspecialchars($article['image_path']); ?>" alt="Current Image" style="max-width:200px;">
        </div>
    <?php endif; ?>
    <label for="pictures">Upload a New Image (optional):</label>
    <input type="file" name="pictures" id="pictures" accept="image/*">
    <br>
    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
    <button type="submit">Update</button>
</form>
<?php include __DIR__ . '/footer.php'; ?>
