<?php
/**
 * v_viewuser.php - шаблон просмотра пользователя
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
 * Пример: echo $userID['name'] - выводит имя текущего пользователя
 */
?>
<div class="grid_8">
  <div class="box">
    <h2>Общая информация</h2>
    <div class="utils">
      <a href="index.php?c=edituser&id=<?= $userID['id_user'] ?>">Редактировать</a>
    </div>
    <div class="content">
      <div class="inner">
        <form action="#" method="get" class="form">
          <div class="columns wat-cf">
            <div class="column ">
              <div class="group">
                <p class="first">
                <div >
                  <a href="#"><img class="avatar" src="../source/<?= $userID['avatar'] ?>" alt="avatar" /></a>
                </div>
                <p>
                  <b>Login</b>: 
                  <?= $userID['login'] ?>
                </p>
                <p>
                  <b>ФИО</b>: 
                  <?= $userID['surname'] . " " . $userID['name'] . " " . $userID['lastname'] ?> 
                </p>
                <p>
                  <b>Дата регистрации</b>: <?= $userID['reg_date'] ?>
                </p>
                <p>
                  <b>Последняя активность</b>: 
                  <?= $session['time_last'] ?>
                </p>
                <p>
                  <b>Текущий статус</b>: 
                  <? if ($session['online'] == "") echo "Оффлайн"; else echo $session['online']?>
                </p>
                <p>
                  <b>Просмотров профиля</b>: 
                  <?= $userID['view'] ?>
                </p>
                <p>
                  <b>Всего отправлено сообщений</b>: 0
                </p>
                </p>  
              </div>
            </div>
          </div>
      </div>
    </div>
  </div>
</div>
<div class="grid_8">
  <div class="box">
    <h2>Информация о пользователе</h2>
    <div class="utils">
      <a href="index.php?c=edituser&id=<?= $userID['id_user'] ?>">Изменить</a>
    </div>
    <div class="column ">
      <div class="group">
        <p class="first">
        <div >
          <a href="#"><img class="avatar" src="images/icons/user_info.png" height="50px" width="50px" alt="Информация о пользователе" title="Информация о пользователе" /></a>
        </div>
        <p>
          <b>Пол</b>: 
          <?= $userID['sex'] ?>
        </p>
        <p>
          <b>Дата рождения</b>: 
          <?= $userID['birth_date'] ?>
        </p>
        <p>
          <b>Родной город</b>: 
          <?= $userID['city'] ?>
        </p>
        <p>
          <b>Мобильный телефон</b>: 
          <?= $userID['mobile_phone'] ?>
        </p>
        <p>
          <b>Домашний телефон</b>: 
          <?= $userID['work_phone'] ?>
        </p>
        <p>
          <b>Skype</b>: 
          <?= $userID['skype'] ?>
        </p>
        <p>
          <b>Email</b>: <?= $userID['email'] ?>
        </p>
        </p>
      </div>
    </div>
  </div>
</div>
</form>

<div class="grid_7">
  <div class="content">
    <div class="inner">
      <form action="index.php?c=users" method="post" class="form">
        <p>
          <button class="button" type="submit">
            <img src="images/icons/tick.png" alt="Закрыть" /> Закрыть
          </button>
        </p>
    </div>
  </div>
</div>