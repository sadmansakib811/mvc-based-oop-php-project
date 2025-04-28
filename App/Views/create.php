<?php include __DIR__ . '/header.php'; ?>
<h1>Create Article</h1>
<form method="post" action="/create" enctype="multipart/form-data">
    <label for="title">Title:</label>
    <input type="text" name="title" required>
    <br>
    <label for="content">Content:</label>
    <textarea name="content" rows="10" cols="50" required></textarea>
    <br>
     <!-- Image upload field -->
     <label for="pictures">Upload an Image:</label>
    <input type="file" name="pictures" id="pictures" accept="image/*" required>
    <br>
    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
    <button type="submit">Create</button>
</form>
<?php include __DIR__ . '/footer.php'; ?>
