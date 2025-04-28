<?php include __DIR__ .'/header.php'?>
<h1>All Articles:</h1>
<?php foreach($articles as $article):?>
    
<a href="/view/<?=htmlspecialchars($article['id']);?>">
 <?= htmlspecialchars($article['title']); ?></a>
<p> By: <?= htmlspecialchars($article['author']) ?></p>
<p><?= nl2br(htmlspecialchars(substr($article['content'], 0,200))) ?></p>
<?php endforeach?>
<div>
    <?php if ($page > 1): ?>
        <a href="/?page=<?= $page - 1; ?>">Previous</a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <?php if ($i == $page): ?>
            <strong><?= $i ?></strong>
        <?php else: ?>
            <a href="/?page=<?= $i ?>"><?= $i ?></a>
        <?php endif; ?>
    <?php endfor; ?>

    <?php if ($page < $totalPages): ?>
        <a href="/?page=<?= $page + 1; ?>">Next</a>
    <?php endif; ?>
</div>


<?php include __DIR__ . '/footer.php'; ?>