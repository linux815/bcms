<?php
/**
 * v_recyclenews.php - шаблон просмотра удаленных новостей
 * ================
 * $recycle - массив, содержащий новости.
 * Содержит в себе элементы: 
 *  id_news - номер новости
 *  title - заголовок новости
 *  text - текст новости
 *  date - дата последнего изменения/создания новости
 * ================
 * Пример: echo $recycle['text'] - выводит текст текущей удаленной новости
 */
?>
<SCRIPT language="javascript">
    function checkAll(obj) {
        'use strict';
        var items = obj.form.getElementsByTagName("input"),
                len, i;

        for (i = 0, len = items.length; i < len; i += 1) {
            if (items.item(i).type && items.item(i).type === "checkbox") {
                if (obj.checked) {
                    items.item(i).checked = true;
                } else {
                    items.item(i).checked = false;
                }
            }
        }
    }
</SCRIPT>
<div class="inner">
  <form action="#" class="form">
    <p>
      <button class="button" type="submit" name="users" formaction="" formmethod="post" formenctype="multipart/form-data">
        <img src="images/icons/user_info.png" alt="Отобразить удаленные новости" title="Отобразить удаленные новости" />
      </button>                   
      <button class="button" type="submit" name="page" formaction="" formmethod="post" formenctype="multipart/form-data">
        <img src="images/icons/file-find.png" alt="Отобразить удаленные страницы" title="Отобразить удаленные страницы" /> 
      </button>
      &nbsp;&nbsp;                    
      <button class="button" type="submit" name="news" formaction="" formmethod="post" formenctype="multipart/form-data">
        <img src="images/icons/edit-file.png" alt="Отобразить удаленные новости" title="Отобразить удаленные новости" /> Новости
      </button> 
    </p>
    <h1>Новости</h1>
    <table class="table">
      <tr>
        <th>
          <input type="checkbox" class="checkbox" name="one" value="all" onclick="checkAll(this)" />
        </th>
        <th>№</th>
        <th>Заголовок</th>
        <th>Последнее изменение</th>
        <th>&nbsp;</th>
      </tr>

      <?php
      $color = true;
      foreach ($recycle as $recycle):
          if ($color):
              ?>
              <tr class="odd">
                <td>
                  <input type="checkbox" class="checkbox" name="id_num[]" value="<?= $recycle['id_news'] ?>" />
                </td>
                <td>
                    <?= $recycle['id_news'] ?>
                </td>
                <td>
                    <?= $recycle['title'] ?>
                </td>
                <td>
                    <?= $recycle['date'] ?>
                </td>
                <td class="last">
                  <a href="index.php?c=recycle&delete=<?= $_GET['delete'] ?>&id_rec=<?= $recycle['id_news'] ?>"><img src="images/icons/restore.png" width="32px" height="32px" alt="Восстановить" title="Восстановить" /></a> 
                  &nbsp; 
                  <a href="index.php?c=recycle&delete=<?= $_GET['delete'] ?>&id_rec=<?= $recycle['id_news'] ?>&no_restore">
                    <img src="images/icons/delete.png" width="32px" height="32px" alt="Удалить навсегда" title="Удалить навсегда" />
                  </a> 
                </td>
              </tr>
              <?php
              $color = false;
          else:
              ?>
              <tr class="even">
                <td>
                  <input type="checkbox" class="checkbox" name="id_num[]" value="<?= $recycle['id_news'] ?>" />
                </td>
                <td>
                    <?= $recycle['id_news'] ?>
                </td>
                <td>
                  <?= $recycle['title'] ?></td><td><?= $recycle['date'] ?>
                </td>
                <td class="last">
                  <a href="index.php?c=recycle&delete=<?= $_GET['delete'] ?>&id_rec=<?= $recycle['id_news'] ?>"><img src="images/icons/restore.png" width="32px" height="32px" alt="Восстановить" title="Восстановить" /></a> 
                  &nbsp; 
                  <a href="index.php?c=recycle&delete=<?= $_GET['delete'] ?>&id_rec=<?= $recycle['id_news'] ?>&no_restore">
                    <img src="images/icons/delete.png" width="32px" height="32px" alt="Удалить навсегда" title="Удалить навсегда" />
                  </a> 
                </td>
              </tr>
              <?php
              $color = true;
          endif;
      endforeach;
      ?>                     
    </table>
    <div class="actions-bar wat-cf">
      <div class="actions">
        <form action="">
          <button class="button" type="submit" name="del" formaction="" formmethod="post" formenctype="multipart/form-data">
            <img src="images/icons/recycle.png"  alt="Восстановить" title="Восстановить" /> Восстановить
          </button>
        </form>
      </div>
      <div class="pagination">
        <?php if ($page == 1 and $page1right == ""): echo "";
        else: ?>
            <?php echo @$pervpage . @$page5left . @$page4left . @$page3left . @$page2left . @$page1left . '<b><span class="active curved">' . @$page . '</span></b>' . @$page1right . @$page2right . @$page3right . @$page4right . @$page5right . @$nextpage; ?>
<?php endif; ?>
      </div>
    </div>
  </form>  
</div>