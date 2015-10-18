<?php
/**
 * v_recycleuser.php - шаблон редактирования пользователя
 * ================
 * $recycle - массив, содержащий удаленных пользователей.
 * Содержит в себе элементы: 
 * 	id_user - номер страницы
 *  login - логин пользователя
 *  password - пароль пользователя (захеширован по MD5)
 *  name - имя
 *  surname - фамилия
 *  lastname - отчество
 *  avatar - аватарка пользователя
 *  email - электронный адрес
 *  reg_date - дата регистрации пользователя
 *  birth_date - дата рождения
 *  sex - пол (Мужской, Женский, Средний)
 *  view - количество просмотров пользователя
 *  city - город
 *  mobile_phone - мобильный телефон
 *  work_phone - рабочий телефон
 *  skype - логин от skype 
 *  
 * ================
 * Пример: echo $recycle['name'] - выводит имя удаленного пользователя
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
        <img src="images/icons/user_info.png" alt="Отобразить удаленные новости" title="Отобразить удаленные новости" /> Пользователи
      </button>                   
      <button class="button" type="submit" name="page" formaction="" formmethod="post" formenctype="multipart/form-data">
        <img src="images/icons/file-find.png" alt="Отобразить удаленные страницы" title="Отобразить удаленные страницы" /> 
      </button>
      &nbsp;&nbsp;                    
      <button class="button" type="submit" name="news" formaction="" formmethod="post" formenctype="multipart/form-data">
        <img src="images/icons/edit-file.png" alt="Отобразить удаленные новости" title="Отобразить удаленные новости" /> 
      </button> 
    </p>
    <h1>Пользователи</h1>
    <table class="table">
      <tr>
        <th>
          <input type="checkbox" class="checkbox" name="one" value="all" onclick="checkAll(this)" />
        </th>
        <th>№</th>
        <th>Логин</th>
        <th>Имя</th>
        <th>Фамилия</th>
        <th>&nbsp;</th>
      </tr>

      <?php
      $color = true;
      foreach($recycle as $recycle):
      if ($color):
      ?>
      <tr class="odd">
        <td>
          <?php if ($recycle['id_user'] == 1): else: ?><input type="checkbox" class="checkbox" name="id_num[]" value="<?= $recycle['id_user'] ?>" /><?php endif;?>
        </td>
        <td>
            <?= $recycle['id_user'] ?>
        </td>
        <td>
            <?= $recycle['login'] ?>
        </td>
        <td>
            <?= $recycle['name'] ?>
        </td>
        <td>
            <?= $recycle['surname'] ?>
        </td>
        <td class="last">
          <a href="index.php?c=recycle&delete=<?= $_GET['delete'] ?>&id_rec=<?= $recycle['id_user'] ?>"><img src="images/icons/restore.png" width="32px" height="32px" alt="Восстановить" title="Восстановить" /></a> 
          &nbsp; 
          <a href="index.php?c=recycle&delete=<?= $_GET['delete'] ?>&id_rec=<?= $recycle['id_user'] ?>&no_restore">
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
          <?php if ($recycle['id_user'] == 1): else: ?><input type="checkbox" class="checkbox" name="id_num[]" value="<?= $recycle['id_user'] ?>" /><?php endif;?>
        </td>
        <td>
            <?= $recycle['id_user'] ?>
        </td>
        <td>
          <?= $recycle['login'] ?></td><td><?= $recycle['name'] ?></td><td><?= $recycle['surname'] ?>
        </td>
        <td class="last">
          <a href="index.php?c=recycle&delete=<?= $_GET['delete'] ?>&id_rec=<?= $recycle['id_user'] ?>"><img src="images/icons/restore.png" width="32px" height="32px" alt="Восстановить" title="Восстановить" /></a> 
          &nbsp; 
          <a href="index.php?c=recycle&delete=<?= $_GET['delete'] ?>&id_rec=<?= $recycle['id_user'] ?>&no_restore">
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
        <?php echo @$pervpage.@$page5left.@$page4left.@$page3left.@$page2left.@$page1left.'<b><span class="active curved">'.@$page.'</span></b>'.@$page1right.@$page2right.@$page3right.@$page4right.@$page5right.@$nextpage; ?>
<?php endif; ?>
      </div>
    </div>
  </form>
</div>