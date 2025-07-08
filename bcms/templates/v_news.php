<form action="" method="post" class="mb-4">
    <div class="d-flex gap-3 flex-wrap mb-3">
        <button type="submit" name="add" class="btn btn-success">
            Добавить новость
        </button>
    </div>

    <?php
    if (empty($allNews)): ?>
        <div class="alert alert-warning">Новости отсутствуют.</div>
    <?php
    else: ?>
        <div class="table-responsive shadow-sm rounded">
            <table class="table table-hover table-striped align-middle mb-0 bg-white">
                <thead class="table-light">
                <tr>
                    <th style="width: 60%;">Заголовок</th>
                    <th>Последнее изменение</th>
                    <th class="text-center">Действия</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($allNews as $news): ?>
                    <tr>
                        <td><?= htmlspecialchars($news['title']) ?></td>
                        <td><?= htmlspecialchars($news['date']) ?></td>
                        <td class="text-center">
                            <a href="index.php?c=editnews&amp;id=<?= (int)$news['id_news'] ?>" title="Редактировать"
                               class="action-btn me-2" aria-label="Редактировать">
                                <img src="images/icons/edit-file.png" alt="Редактировать" width="20" height="20"/>
                            </a>
                            <a href="index.php?c=confirm&amp;delete=news&amp;id=<?= (int)$news['id_news'] ?>"
                               title="Удалить"
                               class="action-btn text-danger"
                               aria-label="Удалить">
                                <img src="images/icons/delete-file.png" alt="Удалить" width="20" height="20"/>
                            </a>
                        </td>
                    </tr>
                <?php
                endforeach; ?>
                </tbody>
            </table>
        </div>

        <?php
        if (!empty($pagination['pages']) && count($pagination['pages']) > 1): ?>
            <nav aria-label="Навигация по страницам" class="mt-4">
                <ul class="pagination justify-content-center flex-wrap gap-1">
                    <?php
                    foreach (['first', 'prev'] as $key): ?>
                        <?php
                        if (!empty($pagination[$key])): ?>
                            <li class="page-item">
                                <a class="page-link" href="?c=news&amp;page=<?= $pagination[$key] ?>"
                                   aria-label="<?= $key === 'first' ? 'Первая страница' : 'Предыдущая страница' ?>">
                                    <?= $key === 'first' ? '&laquo;' : '&lsaquo;' ?>
                                </a>
                            </li>
                        <?php
                        else: ?>
                            <li class="page-item disabled" aria-disabled="true">
                                <span class="page-link"><?= $key === 'first' ? '&laquo;' : '&lsaquo;' ?></span>
                            </li>
                        <?php
                        endif; ?>
                    <?php
                    endforeach; ?>

                    <?php
                    foreach ($pagination['pages'] as $p): ?>
                        <li class="page-item <?= ($p == $pagination['current']) ? 'active' : '' ?>"
                            aria-current="<?= ($p == $pagination['current']) ? 'page' : '' ?>">
                            <a class="page-link" href="?c=news&amp;page=<?= $p ?>"><?= $p ?></a>
                        </li>
                    <?php
                    endforeach; ?>

                    <?php
                    foreach (['next', 'last'] as $key): ?>
                        <?php
                        if (!empty($pagination[$key])): ?>
                            <li class="page-item">
                                <a class="page-link" href="?c=news&amp;page=<?= $pagination[$key] ?>"
                                   aria-label="<?= $key === 'last' ? 'Последняя страница' : 'Следующая страница' ?>">
                                    <?= $key === 'last' ? '&raquo;' : '&rsaquo;' ?>
                                </a>
                            </li>
                        <?php
                        else: ?>
                            <li class="page-item disabled" aria-disabled="true">
                                <span class="page-link"><?= $key === 'last' ? '&raquo;' : '&rsaquo;' ?></span>
                            </li>
                        <?php
                        endif; ?>
                    <?php
                    endforeach; ?>
                </ul>
            </nav>
        <?php
        endif; ?>
    <?php
    endif; ?>
</form>