<?php
/**
 * v_page.php - шаблон просмотра страниц
 * ================
 * $page - массив, содержащий страницы.
 * Содержит в себе элементы: 
 * 	id_page - номер страницы
 *  title - заголовок страницы
 *  text - текст страницы, созданный в редакторе TinyMCE
 *  date - дата последнего изменения/создания страницы
 * ================
 * Пример: echo $page['text'] - выводит текст текущей страницы
 */
?>
<form action="" class="form" method="post">
  <div class="grid_4">
    <p>
      <input type="submit" name="add" value="Добавить новую страницу"/>
    </p>	
  </div>
  <div class="grid_8">
    <p>       
      <input type="text" name="text" />
    </p>
  </div>
  <div class="grid_2">					
    <select name="field" id="field" width="50px">
      <option value="title">Заголовок</option>
    </select>	
  </div>
  <div class="grid_2">
    <p>
      <input type="submit"  name="search" value="Поиск" />
    </p>
  </div>
   <div class="grid_16">
  <?php if ($allPage == null) { echo "<p class='error'> Страницы отсутствуют</p> </div>"; } else { ?>  
   </div>
  <div class="grid_16">
    <table class="table">
      <tr>
        <th width="40%">Заголовок</th>
        <th>Путь</th>
        <th>Последнее изменение</th>
        <th>&nbsp;</th>
      </tr>

      <?php
      $color = true;     
      foreach ($allPage as $page):
          if ($color):
              ?>
              <tr class="odd">
                <td>
                    <?= $page['title'] ?>
                </td>
                <td>
                  <a href="/index.php?c=view&id=<?= $page['id_page'] ?>" target="_blank">
                    /index.php?c=view&id=<?= $page['id_page'] ?>
                  </a>
                </td>
                <td>
                    <?= $page['date'] ?>
                </td>
                <td class="last">
                  <a href="/index.php?c=view&id=<?= $page['id_page'] ?>" target="_blank"><img src="images/icons/file-find.png" 
                                                                                              width="28px" height="28px" 
                                                                                              alt="Посмотреть страницу на сайте" title="Посмотреть страницу на сайте" /></a> 
                  &nbsp;&nbsp;&nbsp; 
                  <a href="index.php?c=editpage&id=<?= $page['id_page'] ?>"><img src="images/icons/edit-file.png" 
                                                                                 width="28px" height="28px" 
                                                                                 alt="Редактировать страницу" title="Редактировать страницу" /></a>
                  <?php if ($page['id_page'] == 1): echo ""; else: ?>
                  &nbsp;&nbsp;&nbsp; 
                  <a href="index.php?c=confirm&delete=page&id=<?= $page['id_page'] ?>"><img src="images/icons/delete-file.png" 
                                                                                            width="28px" height="28px" 
                                                                                            alt="Удалить страницу" title="Удалить страницу" /></a> 
                  <?php endif; ?>
                </td>
              </tr>
              <?php
              $color = false;
          else:
              ?>
              <tr class="even">
                <td>
                    <?= $page['title'] ?>
                </td>
                <td>
                  <a href="/index.php?c=view&id=<?= $page['id_page'] ?>" target="_blank">
                    /index.php?c=view&id=<?= $page['id_page'] ?>
                  </a>
                </td>
                <td>
                    <?= $page['date'] ?>
                </td>
                <td class="last">
                  <a href="/index.php?c=view&id=<?= $page['id_page'] ?>" target="_blank"><img src="images/icons/file-find.png" 
                                                                                              width="28px" height="28px" 
                                                                                              alt="Посмотреть страницу на сайте" title="Посмотреть страницу на сайте" /></a> 
                  &nbsp;&nbsp;&nbsp; 
                  <a href="index.php?c=editpage&id=<?= $page['id_page'] ?>"><img src="images/icons/edit-file.png" 
                                                                                 width="28px" height="28px" 
                                                                                 alt="Редактировать страницу" title="Редактировать страницу" /></a> 
                  <?php if ($page['id_page'] == 1): echo ""; else: ?>
                  &nbsp;&nbsp;&nbsp; 
                  <a href="index.php?c=confirm&delete=page&id=<?= $page['id_page'] ?>"><img src="images/icons/delete-file.png" 
                                                                                            width="28px" height="28px" 
                                                                                            alt="Удалить страницу" title="Удалить страницу" /></a> 
                  <?php endif; ?>
                </td>
              </tr>
              <?php
              $color = true;
        endif;
      endforeach; 
      ?>     	   
    </table>
  </div>
  <div class="actions-bar wat-cf">
    <div class="pagination">
      <?php if ($page1 == 1 and $page1right == ""): echo "";
      else:
          ?>
          <?php echo @$pervpage . @$page5left . @$page4left . @$page3left . @$page2left . @$page1left . '<b><span class="active curved">' . $page1 . '</span></b>' . @$page1right . @$page2right . @$page3right . @$page4right . @$page5right . @$nextpage; ?>
      <?php endif; ?>
    </div>
      
  </div>
    <?php echo "</div></div>";  }?>
</form>
