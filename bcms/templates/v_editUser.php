<?php
/**
 * v_edituser.php - шаблон редактирования пользователя
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
<script type="text/javascript" src="tinymce/tinymce.min.js"></script>
<script type="text/javascript">
    tinymce.init({
        selector: "textarea",
        theme: "modern",
        skin: 'light',
        height: 350,
        menubar: false,
        statusbar: false,
        autosave_interval: "20s",
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak autosave",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor responsivefilemanager"
        ],
        toolbar1: "image",
        image_advtab: true,
        language: 'ru',
        external_filemanager_path: "filemanager/",
        filemanager_title: "Responsive Filemanager",
        browser_spellcheck: true,
        external_plugins: {"filemanager": "../filemanager/plugin.min.js"}
    });
</script>
<div class="grid_16">
  <h2>Редактирование пользователя</h2>
  <?php if (isset($error)): ?>	
      <br/>		
      <p class="error">Пароли не совпадают! Попробуйте еще раз.</p>
      <br/>
  <?php endif; ?> 				
</div>

<form action="" method="post" class="rf form login " id="register"> <!-- rf для проверки полей на пустоту -->
  <div class="grid_6">
    <p>
    <div class="left">
      <label class="label" for="login">Логин</label>		
    </div>						
    <div class="right">
      <input type="text" id="login" class="text_field" value="<?= $userID['login'] ?>" disabled />
    </div>
    </p>
  </div>

  <div class="grid_12">
  </div>	

  <hr/>

  <div class="grid_5">
    <p>
      <label class="label" for="email">Email</label>					
      <input type="text" id="email" class="text_field" value="<?= $userID['email'] ?>" name="email" />
    </p>				
  </div>

  <div class="grid_5">
    <p>
      <label class="label" for="password">Пароль</label>				
      <input type="password" id="password" name="password" class="text_field" />
    </p>
  </div>

  <div class="grid_6">
    <p>
      <label class="label" for="password_apply">Подтверждение пароля</label>				
      <input type="password" id="password_apply" name="password_apply" class="text_field" />
    </p>				
  </div>				

  <hr/>

  <div class="grid_16">
  </div>

  <div class="grid_5">
    <p>
      <label class="label" for="name">Имя</label>						
      <input type="text" id="name" class="text_field" value="<?= $userID['name'] ?>" name="name"/>
    </p>				
  </div>

  <div class="grid_5">
    <p>
      <label class="label" for="surname">Фамилия</label>			
      <input type="text" id="surname" class="text_field" value="<?= $userID['surname'] ?>" name="surname"/>
    </p>				
  </div>	

  <div class="grid_6">
    <p>
      <label class="label" for="lastname">Отчество</label>						
      <input type="text" id="lastname" class="text_field" value="<?= $userID['lastname'] ?>" name="lastname"/>
    </p>				
  </div>

  <div class="grid_5">
    <p>
      <label class="label" for="sex">Пол</label>					
      <select name="sex" id="sex">
        <option <?php if ($userID['sex'] == "Не определен" or $userID['sex'] == ""): ?> selected <?php else: echo "";
  endif; ?> selected="" disabled>Выберите пол</option>
        <option <?php if ($userID['sex'] == "Мужской"): ?> selected <?php else: echo "";
  endif; ?> value="Мужской">Мужской</option>
        <option <?php if ($userID['sex'] == "Женский"): ?> selected <?php else: echo "";
  endif; ?> value="Женский">Женский</option>
        <option <?php if ($userID['sex'] == "Средний"): ?> selected <?php else: echo "";
  endif; ?>value="Средний">Средний</option>
      </select>					
    </p>				
  </div>

  <div class="grid_16">				
  </div>

  <div class="grid_5">
    <p>
      <label class="label" for="birth_date">Дата рождения</label>						
      <input type="text" class="text_field" id="birth_date" value="<?= $userID['birth_date'] ?>" name="birth_date"/>
    </p>				
  </div>	

  <div class="grid_16">				
  </div>				

  <div class="grid_5">
    <p>
      <label class="label" for="city">Родной город</label>					
      <input type="text" id="city" name="city" class="text_field"  value="<?= $userID['city'] ?>"/>
    </p>				
  </div>

  <div class="grid_16">				
  </div>	

  <div class="grid_5">
    <p>
      <label class="label" for="mobile_phone">Мобильный телефон</label>				
      <input type="text" id="mobile_phone" name="mobile_phone" class="text_field"  value="<?= $userID['mobile_phone'] ?>"/>
    </p>				
  </div>

  <div class="grid_16">				
  </div>				

  <div class="grid_5">
    <p>
      <label class="label" for="work_phone">Рабочий телефон</label>			
      <input type="text" id="work_phone" name="work_phone" class="text_field"  value="<?= $userID['work_phone'] ?>"/>
    </p>				
  </div>

  <div class="grid_16">				
  </div>			

  <div class="grid_5">
    <p>
      <label class="label" for="skype">Skype</label>		
      <input type="text" id="skype" name="skype" class="text_field"  value="<?= $userID['skype'] ?>"/>
    </p>				
  </div>

  <div class="grid_16">				
  </div>						

  <div class="grid_8">
    <p>
      <label class="label" for="avatar">Аватар</label>						 		
      <textarea name="avatar" type="text" value="" ><?= $userID['avatar'] ?></textarea>
    </p>
  </div>

  <div class="grid_16">
    <p class="submit">
    <div class="button btn_submit disabled group navform wat-cf">
      <button class="button" type="submit" name="SaveInfo" formaction="" formmethod="post" formenctype="multipart/form-data">
        <img src="images/icons/tick.png" alt="Save" name="SaveInfo" /> Сохранить
      </button>
      <input type="reset" value="Сбросить" /><button class="button" type="button" onclick="javascript:history.go(-1)"><img src="images/icons/cancel.png" alt="Save" name="SaveInfo" /> Назад</button>
    </div>
    </p>
  </div>	
</form>	