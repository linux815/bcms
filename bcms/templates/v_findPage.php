<?php
/**
 * v_findpage.php - шаблон поиска страниц
 * ================
 * $page - массив, содержащий текущую страницу.
 * Содержит в себе элементы: 
 * 	id_page - номер страницы
 *  title - заголовок страницы
 *  text - текст страницы, созданный в редакторе TinyMCE
 *  date - дата последнего изменения/создания страницы
 * ================
 * Пример: echo $page['text'] - выводит текст текущей страницы
 */
?>
<h2>Поиск по страницам</h2>

<div class="grid_16">
    <?php if ($allPage == null) {
        echo "<p class='error'>Поиск не дал результатов.</p> </div>";
    } else { ?>  
    </div>

    <form action="" class="form" method="post">					
      <table class="table">
        <tr>
          <th width="40%">Заголовок</th>
          <th>Путь</th>
          <th>Последнее изменение</th>
          <th>&nbsp;</th>
        </tr>

        <?php
        $color = true;
        foreach ($allPage as $page):
            if ($color):
                ?>
                <tr class="odd">
                  <td>
            <?= $page['title'] ?>
                  </td>
                  <td>
                    <a href="/index.php?c=view&id=<?= $page['id_page'] ?>">/index.php?c=view&id=<?= $page['id_page'] ?></a>
                  </td>
                  <td>
            <?= $page['date'] ?>
                  </td>
                  <td class="last">
                    <a href="/index.php?c=view&id=<?= $page['id_page'] ?>"><img src="images/icons/file-find.png" 
                                                                                width="28px" height="28px" 
                                                                                alt="Посмотреть страницу на сайте" title="Посмотреть страницу на сайте"/></a>
                    &nbsp;&nbsp;&nbsp;
                    <a href="index.php?c=editpage&id=<?= $page['id_page'] ?>"><img src="images/icons/edit-file.png" 
                                                                                   width="28px" height="28px" 
                                                                                   alt="Редактировать страницу" title="Редактировать страницу"/></a> 
                    &nbsp;&nbsp;&nbsp;
                    <a href="index.php?c=confirm&delete=page&id=<?= $page['id_page'] ?>"><img src="images/icons/delete-file.png" 
                                                                                              width="28px" height="28px"
                                                                                              alt="Удалить страницу" title="Удалить страницу"/></a> 
                  </td>
                </tr>
                <?php
                $color = false;
            else:
                ?>
                <tr class="even">
                  <td>
            <?= $page['title'] ?>
                  </td>
                  <td>
                    <a href="/index.php?c=view&id=<?= $page['id_page'] ?>">
                      /index.php?c=view&id=<?= $page['id_page'] ?>
                    </a>
                  </td>
                  <td>
            <?= $page['date'] ?>
                  </td>
                  <td class="last">
                    <a href="/index.php?c=view&id=<?= $page['id_page'] ?>"><img src="images/icons/file-find.png"
                                                                                width="28px" height="28px" 
                                                                                alt="Посмотреть страницу на сайте" title="Посмотреть страницу на сайте"/></a>
                    &nbsp;&nbsp;&nbsp;
                    <a href="index.php?c=editpage&id=<?= $page['id_page'] ?>"><img src="images/icons/edit-file.png" 
                                                                                   width="28px" height="28px" 
                                                                                   alt="Редактировать страницу" title="Редактировать страницу"/></a>
                    &nbsp;&nbsp;&nbsp; 
                    <a href="index.php?c=confirm&delete=page&id=<?= $page['id_page'] ?>"><img src="images/icons/delete-file.png" 
                                                                                              width="28px" height="28px" 
                                                                                              alt="Удалить страницу" title="Удалить страницу"/></a>
                  </td>
                </tr>
                <?php
                $color = true;
            endif;
        endforeach;
        ?>     	   
      </table>
      <div class="actions-bar wat-cf">
        <div class="pagination">
        </div>
      </div>
    </form>
    <?php
    echo "</div></div>";
}?>