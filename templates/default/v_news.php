<hr/>
<?php
foreach ($allNews as $news):
?>
<p align="center"><b><?= $news['date'] ?></b></p>
<p align="center"><b><?= $news['title'] ?></b></p>
<?= $news['text'] ?>
<br/><br/>
<?php
endforeach;
?>     	   
</table>
<p align="center">
    <?php if (isset($_GET['all'])): echo ""; else: ?>
    <a href="index.php?c=view&id=<?php echo $_GET['id']?>&all">Все новости</a>
    <?php endif; ?>
</p>
<br/>