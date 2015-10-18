<?php
/**
 * v_users.php - шаблон вывода всех пользователей
 * ================
 * $allUsers - массив, содержащий пользователей.
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
 * Пример: echo $allUsers['name'] - выводит имя текущего пользователя
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
<form action="" class="form" method="post">
  <div class="grid_11">
    <p>       
      <input type="text" name="text" />
    </p>
  </div>
  <div class="grid_3">					
    <select name="field" id="field" width="50px">
      <option value="login">Логин</option>
      <option value="email">Email</option>
      <option value="surname">Фамилия</option>
    </select>					
  </div>
  <div class="grid_2">
    <p>
      <input type="submit"  name="search" value="Поиск" />
    </p>
  </div>
  <div class="grid_16" style="width:0px">
    <table class="table">
      <tr>
        <th>
          <input type="checkbox" class="checkbox" style="width: 15px !important; margin-right:0px;" name="one" value="all" onclick="checkAll(this)" />
        </th>
        <th>№</th>
        <th>Логин</th>
        <th>Имя</th>
        <th>Фамилия</th>
        <th>&nbsp;</th>
      </tr>

      <?php
      $color = true;
      foreach ($allUsers as $allUsers):
          if ($color):
              ?>
              <tr class="odd">
                <td>
                  <?php if ($allUsers['id_user'] == 1): else: ?><input type="checkbox" class="checkbox" name="id_num[]" style="width: 15px !important; margin-right:0px;" value="<?= $allUsers['id_user'] ?>" /><?php endif; ?>
                </td>
                <td>
                    <?= $allUsers['id_user'] ?>
                </td>
                <td>
                    <?= $allUsers['login'] ?>
                </td>
                <td>
                    <?= $allUsers['name'] ?>
                </td>
                <td>
                    <?= $allUsers['surname'] ?>
                </td>
                <td class="last">
                  <a href="index.php?c=profile&id=<?= $allUsers['id_user'] ?>"><img src="images/icons/user_info.png" 
                                                                                  width="32px" height="32px" 
                                                                                  alt="Показать информацию о пользователе" title="Показать информацию о пользователе" /></a> 
                  &nbsp;&nbsp;&nbsp; 
                  <a href="index.php?c=edituser&id=<?= $allUsers['id_user'] ?>"><img src="images/icons/user_edit.png" 
                                                                                   width="32px" height="32px" 
                                                                                   alt="Редактировать пользователя" title="Редактировать пользователя" /></a> 
                    <?php if ($allUsers['id_user'] == 1): else: ?>
                      &nbsp;&nbsp;&nbsp; 
                      <a href="index.php?c=confirm&delete=users&id=<?= $allUsers['id_user'] ?>"><img src="images/icons/user_delete.png" 
                                                                                                   width="32px" height="32px" 
                                                                                                   alt="Удалить пользователя" title="Удалить пользователя" /></a>
                    <?php endif; ?>	
                </td>
              </tr>
              <?php
              $color = false;
          else:
              ?>
              <tr class="even">
                <td>
                  <?php if ($allUsers['id_user'] == 1): else: ?><input type="checkbox" class="checkbox" name="id_num[]" style="width: 15px !important; margin-right:0px;" value="<?= $allUsers['id_user'] ?>" /><?php endif; ?>
                </td>
                <td>
                  <?= $allUsers['id_user'] ?></td><td><?= $allUsers['login'] ?>
                </td>
                <td>
                  <?= $allUsers['name'] ?></td><td><?= $allUsers['surname'] ?>
                </td>
                <td class="last">
                  <a href="index.php?c=profile&id=<?= $allUsers['id_user'] ?>"><img src="images/icons/user_info.png" 
                                                                                  width="32px" height="32px" 
                                                                                  alt="Показать информацию о пользователе" title="Показать информацию о пользователе" /></a>
                  &nbsp;&nbsp;&nbsp; 
                  <a href="index.php?c=edituser&id=<?= $allUsers['id_user'] ?>"><img src="images/icons/user_edit.png" 
                                                                                   width="32px" height="32px" 
                                                                                   alt="Редактировать пользователя" title="Редактировать пользователя" /></a> 
                    <?php if ($allUsers['id_user'] == 1): else: ?>
                      &nbsp;&nbsp;&nbsp; 
                      <a href="index.php?c=confirm&delete=users&id=<?= $allUsers['id_user'] ?>"><img src="images/icons/user_delete.png" 
                                                                                                   width="32px" height="32px" 
                                                                                                   alt="Удалить пользователя" title="Удалить пользователя" /></a>
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
    <div class="actions">
      <form action="">
        <button class="button" type="submit" name="del" formaction="" formmethod="post" formenctype="multipart/form-data">
          <img src="images/icons/cross.png" alt="Удалить" title="Удалить" /> Удалить
        </button>
      </form>
    </div>
    <div class="actions-bar wat-cf">
      <div class="pagination">
        <?php if ($page == 1 and $page1right == ""): echo "";
        else: ?>
            <?php echo @$pervpage . @$page5left . @$page4left . @$page3left . @$page2left . @$page1left . '<b><span class="active curved">' . $page . '</span></b>' . @$page1right . @$page2right . @$page3right . @$page4right . @$page5right . @$nextpage; ?>
<?php endif; ?>
      </div>
    </div>
  </div>
</form>