<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Результаты поиска по страницам</h5>
        </div>
        <div class="card-body">
            <?php
            if (empty($allPage)): ?>
                <div class="alert alert-warning mb-0">Поиск не дал результатов.</div>
            <?php
            else: ?>
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle mb-0 bg-white shadow-sm rounded">
                        <thead class="table-light">
                        <tr>
                            <th style="width: 40%;">Заголовок</th>
                            <th>Путь</th>
                            <th>Дата</th>
                            <th class="text-center">Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($allPage as $page): ?>
                            <tr>
                                <td><?= htmlspecialchars($page['title']) ?></td>
                                <td>
                                    <a href="/index.php?c=view&amp;id=<?= (int)$page['id_page'] ?>"
                                       class="text-decoration-none" target="_blank">
                                        /index.php?c=view&amp;id=<?= (int)$page['id_page'] ?>
                                    </a>
                                </td>
                                <td><?= htmlspecialchars($page['date']) ?></td>
                                <td class="text-center">
                                    <a href="/index.php?c=view&amp;id=<?= (int)$page['id_page'] ?>" target="_blank"
                                       title="Посмотреть страницу" class="action-btn me-1"
                                       aria-label="Посмотреть страницу">
                                        <img src="images/icons/file-find.png" alt="Посмотреть"/>
                                    </a>
                                    <a href="index.php?c=editpage&amp;id=<?= (int)$page['id_page'] ?>"
                                       title="Редактировать страницу" class="action-btn me-1"
                                       aria-label="Редактировать">
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
            <?php
            endif; ?>
        </div>
    </div>
</div>