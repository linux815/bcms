<div class="row g-4">

    <!-- Блок: Общая информация -->
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Общая информация</h5>
                <a href="index.php?c=edituser&id=<?= $userID['id_user'] ?>" class="btn btn-sm btn-outline-primary">Редактировать</a>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <img src="<?= htmlspecialchars($userID['avatar']) ?>" alt="Аватар" class="rounded-circle" width="96"
                         height="96">
                </div>
                <p><strong>Login:</strong> <?= htmlspecialchars($userID['login']) ?></p>
                <p><strong>ФИО:</strong> <?= htmlspecialchars(
                        $userID['surname'] . " " . $userID['name'] . " " . $userID['lastname'],
                    ) ?></p>
                <p><strong>Дата регистрации:</strong> <?= htmlspecialchars($userID['reg_date']) ?></p>
                <p><strong>Последняя активность:</strong> <?= htmlspecialchars($session['time_last'] ?? '—') ?></p>
                <p><strong>Текущий статус:</strong>
                    <?= empty($session['online']) ? 'Оффлайн' : htmlspecialchars($session['online']) ?>
                </p>
                <p><strong>Просмотров профиля:</strong> <?= (int)$userID['view'] ?></p>
                <p><strong>Всего отправлено сообщений:</strong> 0</p>
            </div>
        </div>
    </div>

    <!-- Блок: Личная информация -->
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Информация о пользователе</h5>
                <a href="index.php?c=edituser&id=<?= $userID['id_user'] ?>" class="btn btn-sm btn-outline-primary">Изменить</a>
            </div>
            <div class="card-body">
                <p><strong>Пол:</strong> <?= htmlspecialchars($userID['sex']) ?></p>
                <p><strong>Дата рождения:</strong> <?= htmlspecialchars($userID['birth_date']) ?></p>
                <p><strong>Родной город:</strong> <?= htmlspecialchars($userID['city']) ?></p>
                <p><strong>Мобильный телефон:</strong> <?= htmlspecialchars($userID['mobile_phone']) ?></p>
                <p><strong>Домашний телефон:</strong> <?= htmlspecialchars($userID['work_phone']) ?></p>
                <p><strong>Skype:</strong> <?= htmlspecialchars($userID['skype']) ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($userID['email']) ?></p>
            </div>
        </div>
    </div>

    <!-- Кнопка закрыть -->
    <div class="col-md-12 text-end">
        <form action="index.php?c=users" method="post">
            <button type="submit" class="btn btn-success mt-3">
                <img src="images/icons/tick.png" alt="Закрыть" class="me-2" width="18"> Закрыть
            </button>
        </form>
    </div>

</div>