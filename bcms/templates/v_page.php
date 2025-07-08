<form action="" method="post" class="mb-4">
    <div class="d-flex flex-wrap gap-3 mb-3 align-items-center">
        <button type="submit" name="add" class="btn btn-success d-flex align-items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-plus-lg"
                 viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                      d="M8 1a.5.5 0 0 1 .5.5v6.5H15a.5.5 0 0 1 0 1H8.5v6.5a.5.5 0 0 1-1 0V9.5H1a.5.5 0 0 1 0-1h6.5V1.5A.5.5 0 0 1 8 1z"/>
            </svg>
            Добавить новую страницу
        </button>

        <div class="input-group w-auto">
            <input type="text" name="text" class="form-control" placeholder="Поиск...">
            <select name="field" id="field" class="form-select">
                <option value="title">Заголовок</option>
            </select>
            <button type="submit" name="search" class="btn btn-primary">Поиск</button>
        </div>
    </div>

    <?php
    if (empty($allPage)): ?>
        <div class="alert alert-warning">Страницы отсутствуют.</div>
    <?php
    else: ?>
        <div class="table-responsive shadow-sm rounded">
            <table class="table table-hover table-striped align-middle mb-0 bg-white shadow-sm rounded">
                <thead class="table-light">
                <tr>
                    <th style="width: 40%;">Заголовок</th>
                    <th>Путь</th>
                    <th>Дата</th>
                    <th class="text-end">Действия</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($allPage as $page): ?>
                    <tr>
                        <td><?= htmlspecialchars($page['title']) ?></td>
                        <td>
                            <a href="/index.php?c=view&amp;id=<?= (int)$page['id_page'] ?>" target="_blank"
                               class="text-decoration-none">
                                /index.php?c=view&amp;id=<?= (int)$page['id_page'] ?>
                            </a>
                        </td>
                        <td><?= htmlspecialchars($page['date']) ?></td>
                        <td class="text-center">
                            <a href="/index.php?c=view&amp;id=<?= (int)$page['id_page'] ?>" target="_blank"
                               title="Посмотреть страницу" class="action-btn me-1" aria-label="Посмотреть страницу">
                                <img src="images/icons/file-find.png" alt="Посмотреть"/>
                            </a>
                            <a href="index.php?c=editpage&amp;id=<?= (int)$page['id_page'] ?>"
                               title="Редактировать страницу" class="action-btn me-1" aria-label="Редактировать">
                                <img src="images/icons/edit-file.png" alt="Редактировать"/>
                            </a>
                            <?php
                            if ((int)$page['id_page'] !== 1): ?>
                                <a href="index.php?c=confirm&amp;delete=page&amp;id=<?= (int)$page['id_page'] ?>"
                                   title="Удалить страницу"
                                   class="action-btn text-danger" aria-label="Удалить">
                                    <img src="images/icons/delete-file.png" alt="Удалить"/>
                                </a>
                            <?php
                            endif; ?>
                        </td>
                    </tr>
                <?php
                endforeach; ?>
                </tbody>
            </table>
        </div>



            <nav aria-label="Навигация по страницам" class="mt-4">
                <ul class="pagination justify-content-center flex-wrap gap-1">
                    <?php
                    foreach (['first', 'prev'] as $key): ?>
                        <?php
                        if (!empty($pagination[$key])): ?>
                            <li class="page-item">
                                <a class="page-link" href="?c=page&amp;page=<?= $pagination[$key] ?>"
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
                            <a class="page-link" href="?c=page&amp;page=<?= $p ?>"><?= $p ?></a>
                        </li>
                    <?php
                    endforeach; ?>

                    <?php
                    foreach (['next', 'last'] as $key): ?>
                        <?php
                        if (!empty($pagination[$key])): ?>
                            <li class="page-item">
                                <a class="page-link" href="?c=page&amp;page=<?= $pagination[$key] ?>"
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
</form>