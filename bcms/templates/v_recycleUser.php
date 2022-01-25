<?php
/**
 * v_recycleuser.php - шаблон просмотра удалённых пользователей
 * Использует: $recycle, $pagination, $page, $_GET['delete']
 */

?>
<script>
    function checkAll(source) {
        const checkboxes = source.form.querySelectorAll('input[type="checkbox"][name="id_num[]"]');
        checkboxes.forEach(chk => chk.checked = source.checked);
    }
</script>

<div class="container my-4">
    <form method="post" class="needs-validation" novalidate>
        <div class="mb-3 d-flex gap-2 flex-wrap">
            <button type="submit" name="users" class="btn btn-outline-primary btn-sm" formaction="" formmethod="post">
                <img src="images/icons/user_info.png" alt="Пользователи" width="16" class="me-1">Пользователи
            </button>
            <button type="submit" name="page" class="btn btn-outline-secondary btn-sm" formaction="" formmethod="post">
                <img src="images/icons/file-find.png" alt="Страницы" width="16" class="me-1">Страницы
            </button>
            <button type="submit" name="news" class="btn btn-outline-secondary btn-sm" formaction="" formmethod="post">
                <img src="images/icons/edit-file.png" alt="Новости" width="16" class="me-1">Новости
            </button>
        </div>

        <h3 class="mb-3">Удалённые пользователи</h3>

        <table class="table table-hover table-bordered align-middle">
            <thead class="table-light">
            <tr>
                <th style="width: 1rem;">
                    <input type="checkbox" onclick="checkAll(this)"/>
                </th>
                <th>№</th>
                <th>Логин</th>
                <th>Имя</th>
                <th>Фамилия</th>
                <th style="width: 7rem;">Действия</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($recycle as $user): ?>
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
                        <a href="index.php?c=recycle&delete=<?= urlencode(
                            $_GET['delete'] ?? '',
                        ) ?>&id_rec=<?= htmlspecialchars($user['id_user']) ?>" title="Восстановить"
                           class="btn btn-sm btn-success me-1" style="padding: 0.25rem 0.5rem;">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </a>
                        <a href="index.php?c=recycle&delete=<?= urlencode(
                            $_GET['delete'] ?? '',
                        ) ?>&id_rec=<?= htmlspecialchars($user['id_user']) ?>&no_restore" title="Удалить навсегда"
                           class="btn btn-sm btn-danger" style="padding: 0.25rem 0.5rem;">
                            <i class="bi bi-x-circle"></i>
                        </a>
                    </td>
                </tr>
            <?php
            endforeach; ?>
            </tbody>
        </table>

        <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
            <button type="submit" name="del" class="btn btn-danger btn-sm d-flex align-items-center gap-1">
                <i class="bi bi-recycle"></i> Восстановить выбранное
            </button>

            <nav aria-label="Pagination">
                <ul class="pagination pagination-sm mb-0">
                    <?php
                    if (!empty($pagination['first'])): ?>
                        <li class="page-item"><a class="page-link" href="index.php?c=recycle&delete=<?= urlencode(
                                $_GET['delete'] ?? '',
                            ) ?>&page=1">« В начало</a></li>
                    <?php
                    endif; ?>

                    <?php
                    if (!empty($pagination['prev'])): ?>
                        <li class="page-item"><a class="page-link" href="index.php?c=recycle&delete=<?= urlencode(
                                $_GET['delete'] ?? '',
                            ) ?>&page=<?= $pagination['prev'] ?>">« Назад</a></li>
                    <?php
                    endif; ?>

                    <?php
                    foreach ($pagination['pages'] as $p): ?>
                        <li class="page-item <?= $p == $page ? 'active' : '' ?>">
                            <a class="page-link" href="index.php?c=recycle&delete=<?= urlencode(
                                $_GET['delete'] ?? '',
                            ) ?>&page=<?= $p ?>"><?= $p ?></a>
                        </li>
                    <?php
                    endforeach; ?>

                    <?php
                    if (!empty($pagination['next'])): ?>
                        <li class="page-item"><a class="page-link" href="index.php?c=recycle&delete=<?= urlencode(
                                $_GET['delete'] ?? '',
                            ) ?>&page=<?= $pagination['next'] ?>">Вперед »</a></li>
                    <?php
                    endif; ?>

                    <?php
                    if (!empty($pagination['last'])): ?>
                        <li class="page-item"><a class="page-link" href="index.php?c=recycle&delete=<?= urlencode(
                                $_GET['delete'] ?? '',
                            ) ?>&page=<?= $pagination['last'] ?>">В конец »</a></li>
                    <?php
                    endif; ?>
                </ul>
            </nav>
        </div>
    </form>
</div>