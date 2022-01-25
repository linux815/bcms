<script>
    function checkAll(source) {
        const checkboxes = document.querySelectorAll('input[type="checkbox"].user-checkbox');
        checkboxes.forEach(checkbox => checkbox.checked = source.checked);
    }
</script>

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Результаты поиска по пользователям</h5>
        </div>
        <div class="card-body">
            <?php
            if (empty($allPage)): ?>
                <div class="alert alert-warning mb-0">Поиск не дал результатов.</div>
            <?php
            else: ?>
                <form method="post">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped align-middle mb-0 bg-white">
                            <thead class="table-light">
                            <tr>
                                <th><input type="checkbox" onclick="checkAll(this)"></th>
                                <th>ID</th>
                                <th>Логин</th>
                                <th>Имя</th>
                                <th>Фамилия</th>
                                <th class="text-center">Действия</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($allPage as $user): ?>
                                <tr>
                                    <td>
                                        <?php
                                        if ((int)$user['id_user'] !== 1): ?>
                                            <input type="checkbox" class="user-checkbox" name="id_num[]"
                                                   value="<?= (int)$user['id_user'] ?>">
                                        <?php
                                        endif; ?>
                                    </td>
                                    <td><?= (int)$user['id_user'] ?></td>
                                    <td><?= htmlspecialchars($user['login']) ?></td>
                                    <td><?= htmlspecialchars($user['name']) ?></td>
                                    <td><?= htmlspecialchars($user['surname']) ?></td>
                                    <td class="text-center">
                                        <a href="index.php?c=profile&amp;id=<?= (int)$user['id_user'] ?>"
                                           class="btn btn-outline-secondary btn-sm me-1" title="Профиль">
                                            <img src="images/icons/user_info.png" alt="Инфо" width="20" height="20">
                                        </a>
                                        <a href="index.php?c=edituser&amp;id=<?= (int)$user['id_user'] ?>"
                                           class="btn btn-outline-primary btn-sm me-1" title="Редактировать">
                                            <img src="images/icons/user_edit.png" alt="Редактировать" width="20"
                                                 height="20">
                                        </a>
                                        <?php
                                        if ((int)$user['id_user'] !== 1): ?>
                                            <a href="index.php?c=confirm&amp;delete=users&amp;id=<?= (int)$user['id_user'] ?>"
                                               class="btn btn-outline-danger btn-sm"
                                               title="Удалить"
                                               onclick="return confirm('Удалить пользователя?');">
                                                <img src="images/icons/user_delete.png" alt="Удалить" width="20"
                                                     height="20">
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

                    <div class="mt-3 d-flex justify-content-between align-items-center">
                        <button type="submit" class="btn btn-danger" name="del"
                                onclick="return confirm('Удалить выбранных пользователей?')">
                            🗑 Удалить выбранных
                        </button>
                        <div class="pagination">
                            <!-- Здесь можно будет добавить пагинацию при необходимости -->
                        </div>
                    </div>
                </form>
            <?php
            endif; ?>
        </div>
    </div>
</div>