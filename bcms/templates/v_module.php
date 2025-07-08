<div class="container py-4">
    <h2 class="mb-4">Управление модулями</h2>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card module-card h-100">
                <div class="card-body">
                    <h5 class="card-title d-flex justify-content-between align-items-center">
                        Новости
                        <a href="index.php?c=modules&news"
                           class="btn btn-sm <?= $news ? 'btn-danger' : 'btn-success' ?>">
                            <?= $news ? 'Выключить' : 'Включить' ?>
                        </a>
                    </h5>
                    <p class="card-text mt-3 text-muted">
                        Модуль "Новости" будет <?= $news ? 'отключён' : 'включён' ?> на всех страницах вашего сайта.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card module-card h-100">
                <div class="card-body">
                    <h5 class="card-title d-flex justify-content-between align-items-center">
                        Гостевая книга
                        <a href="index.php?c=modules&ghost"
                           class="btn btn-sm <?= $ghost ? 'btn-danger' : 'btn-success' ?>">
                            <?= $ghost ? 'Выключить' : 'Включить' ?>
                        </a>
                    </h5>
                    <p class="card-text mt-3 text-muted">
                        Модуль "Гостевая книга" будет <?= $ghost ? 'отключён' : 'включён' ?> на всех страницах сайта.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card module-card h-100">
                <div class="card-body">
                    <h5 class="card-title d-flex justify-content-between align-items-center">
                        Обратная связь
                        <a href="index.php?c=modules&review"
                           class="btn btn-sm <?= $review ? 'btn-danger' : 'btn-success' ?>">
                            <?= $review ? 'Выключить' : 'Включить' ?>
                        </a>
                    </h5>
                    <p class="card-text mt-3 text-muted">
                        <a href="index.php?c=settings">Настроить</a> отправку сообщений — можно выбрать email или
                        админку.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>