<?php
/**
 * v_review.php - шаблон просмотра отзывов о сайте
 * ================
 * $review_id - массив, содержащий отзывы.
 * Содержит в себе элементы: 
 * 	id_review - номер отзыва
 *  title - тема отзва
 *  text - текст отзыва
 *  email - электронный ящик пользователя, отправляющего отзыв
 * 	name - имя пользователя, отправляющего отзыв
 * ================
 * Пример: echo $review_id['text'] - выводит текст отзыва
 */
?>
<?php if (isset($_GET['view'])): ?>
    <h2>Обратная связь</h2>
    <p> 
      <b>Имя:</b> 
      <?= $review_id['name'] ?> 
      <br/>
      <b>Email:</b> 
      <a href="mailto:<?= $review_id['email'] ?>?subject=RE: <?= $review_id['title'] ?>">
          <?= $review_id['email'] ?>
      </a> 
      <br/>
      <b>Заголовок:</b> 
      <?= $review_id['title'] ?> 
      <br/>
      <b>Сообщение:</b> 
      <?= $review_id['text']; ?> 
  <?php else: ?>
    <form action="" class="form" method="post">
      <div class="grid_4">
      </div>
      <h2>Обратная связь</h2>
      <table class="table">
        <tr>
          <th>Имя</th>
          <th>Email</th>
          <th>Тема</th>
          <th>Сообщение</th>
          <th>Действия</th>
        </tr>

        <?php
        $color = true;
        foreach ($reviews as $reviews):
            if (strlen($reviews['text']) > 200) {
                $temp = substr($reviews['text'], 0, strpos($reviews['text'], " ", 200));
                $temp .= $temp . "...";
            } else {
                $temp = $reviews['text'];
            }
            $text = $temp;
            if ($color):
                ?>
                <tr class="odd">
                  <td>
            <?= $reviews['name'] ?>
                  </td>           
                  <td>
                    <a href="mailto:<?= $reviews['email'] ?>?subject=RE: <?= $reviews['title'] ?>">
            <?= $reviews['email'] ?>
                    </a>
                  </td>
                  <td>
            <?= $reviews['title'] ?>
                  </td>
                  <td>
            <?= $text; ?>
                  </td>
                  <td align="center">
                    <a href="index.php?c=review&view=<?= $reviews['id_review'] ?>">Просмотреть</a>
                    <br/>
                    <a href="index.php?c=review&delete=<?= $reviews['id_review'] ?>">Удалить</a>
                  </td>
                </tr>
                <?php
                $color = false;
            else:
                ?>
                <tr class="even">
                  <td>
            <?= $reviews['name'] ?>
                  </td>           
                  <td>
                    <a href="mailto:<?= $reviews['email'] ?>?subject=RE: <?= $reviews['title'] ?>">
            <?= $reviews['email'] ?>
                    </a>
                  </td>
                  <td>
            <?= $reviews['title'] ?>
                  </td>
                  <td>
                    <? echo $text;?>
                  </td>
                  <td align="center">
                    <a href="index.php?c=review&view=<?= $reviews['id_review'] ?>">Просмотреть</a>
                    <br/>
                    <a href="index.php?c=review&delete=<?= $reviews['id_review'] ?>">Удалить</a>
                  </td>
                </tr>		          		                
                <?php
                $color = true;
            endif;
        endforeach;
        ?>     	   
      </table>
    </form>
<?php endif; ?>