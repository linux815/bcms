<?php
/**
 * v_findusers.php - шаблон поиска пользователей
 * ================
 * $userID - массив, содержащий текущего пользователя.
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
 * Пример: echo $users['name'] - выводит имя текущего пользователя
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
<h2>Поиск по пользователям</h2>
<div class="grid_16">
<?php if ($allPage == null) { echo "<p class='error'>Поиск не дал результатов.</p> </div>"; } else { ?>  
</div>
<div class="inner">
  <form action="#" class="form">
    <table class="table">
      <tr>
        <th><input type="checkbox" class="checkbox" name="one" value="all" onclick="checkAll(this)" /></th>
        <th>№</th>
        <th>Логин</th>
        <th>Имя</th>
        <th>Фамилия</th>
        <th>&nbsp;</th>
      </tr>

      <?php
      $color = true;
      foreach ($allPage as $users):
          if ($color):
              ?>
              <tr class="odd">
                <td>
                  <?php if ($users['id_user'] == 1): else: ?><input type="checkbox" class="checkbox" name="id_num[]" value="<?= $users['id_user'] ?>" /><?php endif; ?>
                </td>
                <td>
                    <?= $users['id_user'] ?>
                </td>
                <td>
                  <?= $users['login'] ?></td><td><?= $users['name'] ?></td><td><?= $users['surname'] ?>
                </td>
                <td class="last">
                  <a href="index.php?c=profile&id=<?= $users['id_user'] ?>"><img src="images/icons/user_info.png" 
                                                                                 width="32px" height="32px" 
                                                                                 alt="Показать информацию о пользователе" title="Показать информацию о пользователе" /></a> 
                  &nbsp;&nbsp;&nbsp; 
                  <a href="index.php?c=edituser&id=<?= $users['id_user'] ?>"><img src="images/icons/user_edit.png" 
                                                                                  width="32px" height="32px" 
                                                                                  alt="Редактировать пользователя" title="Редактировать пользователя" /></a> 
                    <?php if ($users['id_user'] == 1): else: ?>
                      &nbsp;&nbsp;&nbsp; 
                      <a href="index.php?c=confirm&delete=users&id=<?= $users['id_user'] ?>"><img src="images/icons/user_delete.png" 
                                                                                                  width="32px" height="32px" 
                                                                                                  alt="Удалить пользователя" title="Удалить пользователя" /></a>
                    </td>
                <?php endif; ?>
              </tr>
              <?php
              $color = false;
          else:
              ?>
              <tr class="even">
                <td>
                  <?php if ($users['id_user'] == 1): else: ?><input type="checkbox" class="checkbox" name="id_num[]" value="<?= $users['id_user'] ?>" /><?php endif; ?>
                </td>
                <td>
                    <?= $users['id_user'] ?>
                </td>
                <td>
                    <?= $users['login'] ?>
                </td>
                <td>
                    <?= $users['name'] ?>
                </td>
                <td>
                    <?= $users['surname'] ?>
                </td>
                <td class="last">
                  <a href="index.php?c=profile&id=<?= $users['id_user'] ?>"><img src="images/icons/user_info.png" 
                                                                                 width="32px" height="32px" 
                                                                                 alt="Показать информацию о пользователе" title="Показать информацию о пользователе" /></a>
                  &nbsp;&nbsp;&nbsp; 
                  <a href="index.php?c=edituser&id=<?= $users['id_user'] ?>"><img src="images/icons/user_edit.png" 
                                                                                  width="32px" height="32px" 
                                                                                  alt="Редактировать пользователя" title="Редактировать пользователя" /></a> 
                    <?php if ($users['id_user'] == 1): else: ?>
                      &nbsp;&nbsp;&nbsp; 
                      <a href="index.php?c=confirm&delete=users&id=<?= $users['id_user'] ?>"><img src="images/icons/user_delete.png" 
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
        </div>
      </div>
    </div>
  </form>
</div>
    <?php
    echo "</div></div>";
}?>