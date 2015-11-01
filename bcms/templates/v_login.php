<?php
/**
 * v_login.php - шаблон страницы авторизации
 * ================
 * $error - если данные не верны, возвращает 1 
 */
?>
<div class="grid_11">
  <h2>Авторизация</h2>
  <form method="post">
    <?php if (isset($error)): ?> <p class='error'>Неверный логин или пароль! Попробуйте еще раз.</p> <?php endif; ?>
    <p>
      <label for="login">Логин </label>
      <input type="text" width="30" name="login">
    </p>
    <p>
      <label for="password">Пароль </label>
      <input type="password" name="password" /><br/>
    </p>
    <p>
      <label for="remember" style="font-size: 12px;font-weight:normal;"><input type="checkbox" name="remember" checked style="margin:0px;padding:0px;width:20px;height:15px;line-height:0px;vertical-align: sub;" />
        Запомнить меня
      </label>
    </p>	
    <input type="submit" value="Войти"/>
  </form>
</div>
<div class="grid_5">
  <h2>Добро пожаловать</h2>
  <ol>
    <li><a href="http://maxicms.esy.es/">Домашняя страница</a></li>
    <li><a href="mailto:ivan.bazhenov@gmail.com?subject=Вопрос по MaxiCMS">Написать письмо</a></li>
    <li><a href="http://maxicms.esy.es/index.php?c=quest">Часто задаваемые вопросы</a></li>
  </ol>
</div>