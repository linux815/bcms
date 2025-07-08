<div class="row g-4">
    <!-- Левая колонка: Общая информация (шире) -->
    <div class="col-md-6">
        <div class="card card-info p-3 h-100">
            <h2 class="mb-4">Общая информация</h2>
            <div class="version-info mb-4">
                <div class="d-flex align-items-start mb-3 border-bottom pb-3">
                    <img src="images/icons/B.png" alt="Версия 4.0.0" title="Версия 4.0.0"
                         style="width:128px; height:128px;" class="me-3">
                    <div>
                        <p class="mb-0"><strong>Текущая версия CMS:</strong> 4.0.0</p>
                    </div>
                </div>

                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>Название сайта:</strong> <?= htmlspecialchars($nameSite) ?></li>
                    <li class="list-group-item"><strong>Имя базы данных:</strong> <?= htmlspecialchars($dbName) ?></li>
                    <li class="list-group-item"><strong>Дата и время сервера:</strong> <?= date('d.m.Y H:i:s') ?></li>
                    <li class="list-group-item"><strong>Пользователи:</strong> <?= $userCount ?></li>
                    <li class="list-group-item"><strong>Страницы:</strong> <?= $pageCount ?></li>
                    <li class="list-group-item"><strong>Новости:</strong> <?= $newsCount ?></li>
                    <li class="list-group-item"><strong>Гостевая книга:</strong> <?= $guestbookCount ?></li>
                    <li class="list-group-item"><strong>Отзывы:</strong> <?= $reviewCount ?></li>
                    <li class="list-group-item"><strong>Удалённые элементы:</strong> <?= $recycleCount ?></li>
                    <li class="list-group-item">
                        <strong>Модули:</strong>
                        Новости (<?= $settings['news'] ? 'вкл' : 'выкл' ?>),
                        Гостевая книга (<?= $settings['ghost'] ? 'вкл' : 'выкл' ?>),
                        Отзывы (<?= $settings['review'] ? 'вкл' : 'выкл' ?>)
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Правая колонка: С чего начать + Сообщить об ошибке -->
    <div class="col-md-6 d-flex flex-column gap-4">
        <!-- С чего начать -->
        <div class="card card-minheight p-3">
            <h2>С чего начать?</h2>
            <ul class="admin-start-list">
                <li><a href="index.php?c=addpage"><img src="images/icons/add-file.png" alt="">Создать страницу</a></li>
                <li><a href="index.php?c=addnews"><img src="images/icons/edit-file.png" alt="">Добавить новость</a></li>
                <li><a href="index.php?c=modules"><img src="images/icons/application_edit.png" alt="">Подключить модули</a>
                </li>
                <li><a href="index.php?c=recycle"><img src="images/icons/recycle.png" alt="">Перейти в корзину</a></li>
                <li><a href="index.php?c=review"><img src="images/icons/file-find.png" alt="">Прочитать отзывы</a></li>
            </ul>
        </div>

        <!-- Сообщить об ошибке -->
        <div class="card p-3">
            <h2>Сообщить об ошибке</h2>
            <p>Если вы заметили баг или хотите предложить улучшение — оставьте issue на GitHub.</p>
            <a href="https://github.com/linux815/bcms/issues" target="_blank" rel="noopener noreferrer"
               class="btn btn-outline-primary mt-2">
                Перейти на GitHub
            </a>
        </div>
    </div>
</div>