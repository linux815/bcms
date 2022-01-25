<hr/>

<?php
foreach ($allNews as $news): ?>
    <p class="text-center fw-bold"><?= htmlspecialchars($news['date']) ?></p>
    <p class="text-center fw-bold"><?= htmlspecialchars($news['title']) ?></p>
    <div><?= $news['text'] ?></div>
    <br/><br/>
<?php
endforeach; ?>

<p class="text-center">
    <?php
    if (empty($_GET['all'])): ?>
        <a href="index.php?c=view&id=<?= urlencode($_GET['id'] ?? '') ?>&all">Все новости</a>
    <?php
    endif; ?>
</p>
<br/>