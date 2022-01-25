<?php
/** @var array $allUsers */

/** @var array $pagination */
/** @var int $page */
?>

<script>
    function checkAll(obj) {
        'use strict';
        const items = obj.form.querySelectorAll("input[type='checkbox']");
        items.forEach(item => item.checked = obj.checked);
    }
</script>

<form method="post" action="">
    <div class="mb-3 d-flex gap-2">
        <input type="text" name="text" class="form-control" placeholder="Поиск">
        <select name="field" class="form-select" style="width: 150px;">
            <option value="login">Логин</option>
            <option value="email">Email</option>
            <option value="surname">Фамилия</option>
        </select>
        <button type="submit" name="search" class="btn btn-primary">Поиск</button>
    </div>

    <table class="table table-striped table-hover align-middle">
        <thead>
        <tr>
            <th style="width: 40px;">
                <input type="checkbox" onclick="checkAll(this)"/>
            </th>
            <th>№</th>
            <th>Логин</th>
            <th>Имя</th>
            <th>Фамилия</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($allUsers as $user): ?>
            <tr>
                <td>
                    <?php
                    if ($user['id_user'] != 1): ?>
                        <input type="checkbox" name="id_num[]" value="<?= htmlspecialchars($user['id_user']) ?>">
                    <?php
                    endif; ?>
                </td>
                <td><?= htmlspecialchars($user['id_user']) ?></td>
                <td><?= htmlspecialchars($user['login']) ?></td>
                <td><?= htmlspecialchars($user['name']) ?></td>
                <td><?= htmlspecialchars($user['surname']) ?></td>
                <td>
                    <a href="index.php?c=profile&id=<?= $user['id_user'] ?>" title="Показать информацию"
                       class="action-btn">
                        <img src="images/icons/user_info.png" alt="Информация">
                    </a>
                    <a href="index.php?c=edituser&id=<?= $user['id_user'] ?>" title="Редактировать пользователя"
                       class="action-btn">
                        <img src="images/icons/user_edit.png" alt="Редактировать">
                    </a>
                    <?php
                    if ($user['id_user'] != 1): ?>
                        <a href="index.php?c=confirm&delete=users&id=<?= $user['id_user'] ?>"
                           title="Удалить пользователя" class="action-btn text-danger">
                            <img src="images/icons/user_delete.png" alt="Удалить">
                        </a>
                    <?php
                    endif; ?>
                </td>
            </tr>
        <?php
        endforeach; ?>
        </tbody>
    </table>

    <div class="d-flex justify-content-between align-items-center">
        <button type="submit" name="del" class="btn btn-danger">
            <img src="images/icons/cross.png" alt="Удалить" width="16" height="16"> Удалить выбранные
        </button>

        <?php
        if (count($pagination['pages'] ?? []) > 1): ?>
            <nav aria-label="Страницы">
                <ul class="pagination mb-0">
                    <?php
                    if (!empty($pagination['first'])): ?>
                        <li class="page-item"><a class="page-link"
                                                 href="index.php?c=users&page=<?= $pagination['first'] ?>">« В
                                начало</a></li>
                    <?php
                    else: ?>
                        <li class="page-item disabled"><span class="page-link">« В начало</span></li>
                    <?php
                    endif; ?>

                    <?php
                    if (!empty($pagination['prev'])): ?>
                        <li class="page-item"><a class="page-link"
                                                 href="index.php?c=users&page=<?= $pagination['prev'] ?>">« Назад</a>
                        </li>
                    <?php
                    else: ?>
                        <li class="page-item disabled"><span class="page-link">« Назад</span></li>
                    <?php
                    endif; ?>

                    <?php
                    foreach ($pagination['pages'] as $p): ?>
                        <?php
                        if ($p == $page): ?>
                            <li class="page-item active" aria-current="page"><span class="page-link"><?= $p ?></span>
                            </li>
                        <?php
                        else: ?>
                            <li class="page-item"><a class="page-link"
                                                     href="index.php?c=users&page=<?= $p ?>"><?= $p ?></a></li>
                        <?php
                        endif; ?>
                    <?php
                    endforeach; ?>

                    <?php
                    if (!empty($pagination['next'])): ?>
                        <li class="page-item"><a class="page-link"
                                                 href="index.php?c=users&page=<?= $pagination['next'] ?>">Вперед »</a>
                        </li>
                    <?php
                    else: ?>
                        <li class="page-item disabled"><span class="page-link">Вперед »</span></li>
                    <?php
                    endif; ?>

                    <?php
                    if (!empty($pagination['last'])): ?>
                        <li class="page-item"><a class="page-link"
                                                 href="index.php?c=users&page=<?= $pagination['last'] ?>">В конец »</a>
                        </li>
                    <?php
                    else: ?>
                        <li class="page-item disabled"><span class="page-link">В конец »</span></li>
                    <?php
                    endif; ?>
                </ul>
            </nav>
        <?php
        endif; ?>
    </div>
</form>