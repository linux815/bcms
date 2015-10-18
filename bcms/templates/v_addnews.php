<?php
/*
 * v_addnews.php - шаблон добавления новости
 */
?>
<script type="text/javascript" src="tinymce/tinymce.min.js"></script>
<script type="text/javascript">
    tinymce.init({
        selector: "textarea",
        theme: "modern",
        skin: 'light',
        height: 350,
        autosave_interval: "20s",
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak autosave",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor responsivefilemanager"
        ],
        toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image hr | print preview media | forecolor backcolor emoticons",
        image_advtab: true,
        language: 'ru',
        external_filemanager_path: "../filemanager/",
        filemanager_title: "Responsive Filemanager",
        browser_spellcheck: true,
        external_plugins: {"filemanager": "../filemanager/plugin.min.js"}
    });
</script>

<form method="post" action="somepage">

  <?php
   if ($error == ""):
   else:
  ?>

  <p class="error"><?= $error ?></p>

   <?php endif; ?>

  <p>
    <label>Заголовок <small>Время к новости добавляется автоматически</small></label>
    <input type="text" name="title" style="width: 99%;"/>
  </p>

  <textarea name="content" style="width:100%">
	  <p style="text-align: center;"></p>
  </textarea>

  <br/>

  <p>
    <button class="button" type="submit" name="SaveInfo" formaction="" formmethod="post" formenctype="multipart/form-data">
      <img src="images/icons/tick.png" alt="Добавить" title="Добавить" name="Save" /> Добавить
    </button>
  </p>	
</form>