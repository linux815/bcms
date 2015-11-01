<?php
/**
 * v_recyclepage.php - шаблон просмотра удаленных страниц
 * ================
 * $recycle - массив, содержащий удаленные страницы.
 * Содержит в себе элементы: 
 * 	id_page - номер страницы
 *  title - заголовок страницы
 *  text - текст страницы, созданный в редакторе TinyMCE
 *  date - дата последнего изменения/создания страницы
 * ================
 * Пример: echo $recycle['text'] - выводит текст удаленной страницы
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
        <img src="images/icons/file-find.png" alt="Отобразить удаленные страницы" title="Отобразить удаленные страницы" /> Страницы
      </button>
      &nbsp;&nbsp;                    
      <button class="button" type="submit" name="news" formaction="" formmethod="post" formenctype="multipart/form-data">
        <img src="images/icons/edit-file.png" alt="Отобразить удаленные новости" title="Отобразить удаленные новости" />
      </button> 
    </p>
    <h1>Страницы</h1>
    <table class="table">
      <tr>
        <th><input type="checkbox" class="checkbox" name="one" value="all" onclick="checkAll(this)" /></th>
        <th>Заголовок</th>
        <th>Путь</th>
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
                  <input type="checkbox" class="checkbox" name="id_num[]" value="<?= $recycle['id_page'] ?>" />
                </td>
                <td>
                    <?= $recycle['title'] ?>
                </td>
                <td>
                  <a href="/index.php?c=view&id=<?= $recycle['id_page'] ?>">
                    /index.php?c=view&id=<?= $recycle['id_page'] ?>
                  </a>
                </td>
                <td>
                    <?= $recycle['date'] ?>
                </td>
                <td class="last">
                  <a href="index.php?c=recycle&delete=<?= $_GET['delete'] ?>&id_rec=<?= $recycle['id_page'] ?>"><img src="images/icons/restore.png" width="32px" height="32px" alt="Восстановить" title="Восстановить" /></a> 
                  &nbsp; 
                  <a href="index.php?c=recycle&delete=<?= $_GET['delete'] ?>&id_rec=<?= $recycle['id_page'] ?>&no_restore">
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
                  <input type="checkbox" class="checkbox" name="id_num[]" value="<?= $recycle['id_page'] ?>" />
                </td>
                <td>
                    <?= $recycle['title'] ?>
                </td>
                <td>
                  <a href="/index.php?c=view&id=<?= $recycle['id_page'] ?>">
                    /index.php?c=view&id=<?= $recycle['id_page'] ?>
                  </a>
                </td>
                <td>
                    <?= $recycle['date'] ?>
                </td>
                <td class="last">
                  <a href="index.php?c=recycle&delete=<?= $_GET['delete'] ?>&id_rec=<?= $recycle['id_page'] ?>"><img src="images/icons/restore.png" width="32px" height="32px" alt="Восстановить" title="Восстановить" /></a> 
                  &nbsp; 
                  <a href="index.php?c=recycle&delete=<?= $_GET['delete'] ?>&id_rec=<?= $recycle['id_page'] ?>&no_restore">
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