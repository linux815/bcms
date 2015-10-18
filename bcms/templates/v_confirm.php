<?php
/**
 * v_confirm.php - шаблон подтверждения действий
 * ================
 * $char - выводимое сообщение
 */
?>
<div id="wrapper" class="wat-cf">
  <div id="main">
    <div class="block" id="block-tables">
      <div class="content">
        <h2 class="title"><?= $char ?></h2>
        <div class="inner">              
          <div class="actions-bar wat-cf">
            <div> 
              <form action="">          
                <button class="button" type="submit" name="Yes" value="Yes" formaction="" formmethod="post" formenctype="multipart/form-data">
                  <img src="images/icons/tick.png" alt="Удалить" /> Да
                </button>
                <button class="button" type="submit" name="No" value="No" formaction="" formmethod="post" formenctype="multipart/form-data">
                  <img src="images/icons/cross.png" alt="Не удалять" /> Нет
                </button>
              </form>
            </div> 
          </div>              
        </div>
      </div>
    </div>
  </div>
</div>