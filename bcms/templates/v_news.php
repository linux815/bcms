<?php
/**
 * v_news.php - шаблон просмотра новостей
 * ================
 * $news - массив, содержащий новости.
 * Содержит в себе элементы: 
 * 	id_news - номер новости
 *  title - заголовок новости
 *  text - текст новости
 *  date - дата последнего изменения/создания новости
 * ================
 * Пример: echo $news['text'] - выводит текст текущей новости
 */
?>
<form action="" class="form" method="post">
  <div class="grid_4">
    <p>
      <input type="submit" name="add" value="Добавить новость"/>
    </p>	
  </div>
   <div class="grid_16">
  <?php if ($allNews == null) { echo "<p class='error'> Новости отсутствуют</p> </div>"; } else { ?>  
   </div>  
  <div class="grid_16">
    <table class="table">
      <tr>
        <th width="40%">Заголовок</th>
        <th>Последнее изменение</th>
        <th>&nbsp;</th>
      </tr>

      <?php
      $color = true;
      foreach ($allNews as $news):
          if ($color):
              ?>
              <tr class="odd">      
                <td>
                    <?= $news['title'] ?>
                </td>
                <td>
                    <?= $news['date'] ?>
                </td>
                <td class="last">
                  &nbsp;&nbsp;&nbsp; 
                  <a href="index.php?c=editnews&id=<?= $news['id_news'] ?>"><img src="images/icons/edit-file.png"
                                                                               width="28px" height="28px" 
                                                                               alt="Редактировать новость" title="Редактировать новость" /></a> 
                  &nbsp;&nbsp;&nbsp; 
                  <a href="index.php?c=confirm&delete=news&id=<?= $news['id_news'] ?>"><img src="images/icons/delete-file.png" 
                                                                                          width="28px" height="28px" 
                                                                                          alt="Удалить новость" title="Удалить новость" /></a> 
                </td>
              </tr>
              <?php
              $color = false;
          else:
              ?>
              <tr class="even">
                <td>
                    <?= $news['title'] ?>
                </td>
                <td>
                    <?= $news['date'] ?>
                </td>
                <td class="last">
                  &nbsp;&nbsp;&nbsp; 
                  <a href="index.php?c=editnews&id=<?= $news['id_news'] ?>"><img src="images/icons/edit-file.png" 
                                                                               width="28px" height="28px" 
                                                                               alt="Редактировать новость" title="Редактировать новость" /></a> 
                  &nbsp;&nbsp;&nbsp; 
                  <a href="index.php?c=confirm&delete=news&id=<?= $news['id_news'] ?>"><img src="images/icons/delete-file.png" 
                                                                                          width="28px" height="28px" 
                                                                                          alt="Удалить новость" title="Удалить новость" /></a> 
                </td>
              </tr>
              <?php
              $color = true;
          endif;
      endforeach;
      ?>     	   
    </table>
    <div class="actions-bar wat-cf">
      <div class="pagination">
        <?php if ($page1 == 1 and $page1right == ""): echo "";
        else: ?>
            <?php echo @$pervpage . @$page5left . @$page4left . @$page3left . @$page2left . @$page1left . '<b><span class="active curved">' . $page1 . '</span></b>' . @$page1right . @$page2right . @$page3right . @$page4right . @$page5right . @$nextpage; ?>
<?php endif; ?>
      </div>
    </div>	
  </div>
  <?php echo "</div></div>";  }?>
</form>