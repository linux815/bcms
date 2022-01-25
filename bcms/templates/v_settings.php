<h1 class="mb-4">Настройки</h1>

<?php
if (!empty($success)): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        Настройки успешно сохранены.
        <a href="index.php" class="alert-link ms-2">Перейти на главную</a>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Закрыть"></button>
    </div>
<?php
endif; ?>

<form method="post" action="#" class="needs-validation" novalidate>

    <!-- Общие настройки -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header">
            <h5 class="mb-0">Общие настройки</h5>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label for="namesite" class="form-label">Название сайта</label>
                <input type="text" class="form-control" id="namesite" name="namesite"
                       value="<?= htmlspecialchars($nameSite) ?>" required>
                <div class="invalid-feedback">Пожалуйста, введите название сайта.</div>
            </div>

            <div class="mb-3 d-flex align-items-center">
                <label for="template" class="form-label me-2 mb-0">Имя шаблона</label>
                <a href="#" tabindex="0" role="button" data-bs-toggle="tooltip" data-bs-placement="right"
                   title="По умолчанию доступны шаблоны: default">
                    <img src="images/icons/Help.png" alt="Помощь" width="24" height="24">
                </a>
            </div>
            <input type="text" class="form-control mb-3" id="template" name="template"
                   value="<?= htmlspecialchars($template) ?>" required>
            <div class="invalid-feedback">Пожалуйста, введите имя шаблона.</div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="menuUsers" name="menu"
                       value="users" <?= ($m_users == 1) ? 'checked' : '' ?>>
                <label class="form-check-label" for="menuUsers">Отображать пункт меню "Пользователи"</label>
            </div>
        </div>
    </div>

    <!-- Модуль обратной связи -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header">
            <h5 class="mb-0">Модуль "Обратная связь"</h5>
        </div>
        <div class="card-body">
            <fieldset class="mb-0">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="review" id="reviewEmail"
                           value="email" <?= ($md_review === "email") ? 'checked' : '' ?>>
                    <label class="form-check-label" for="reviewEmail">Отправлять данные на Ваш email</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="review" id="reviewAdmin"
                           value="admin" <?= ($md_review === "admin") ? 'checked' : '' ?>>
                    <label class="form-check-label" for="reviewAdmin">Отправлять данные в администраторский
                        раздел</label>
                </div>
            </fieldset>
        </div>
    </div>

    <!-- SEO настройки -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header">
            <h5 class="mb-0">SEO</h5>
        </div>
        <div class="card-body">
            <div class="mb-3 d-flex align-items-center">
                <label for="keywords" class="form-label me-2 mb-0">Ключевые слова</label>
                <a href="#" tabindex="0" role="button" data-bs-toggle="tooltip" data-bs-placement="right"
                   title="Ключевые слова нужно вводить через запятые или пробелы. Например: еда, горох, хлеб">
                    <img src="images/icons/Help.png" alt="Помощь" width="24" height="24">
                </a>
            </div>
            <input type="text" class="form-control mb-3" id="keywords" name="keywords"
                   value="<?= htmlspecialchars($keywords) ?>">

            <label for="description" class="form-label">Краткое описание сайта</label>
            <input type="text" class="form-control" id="description" name="description"
                   value="<?= htmlspecialchars($description) ?>">
        </div>
    </div>

    <button type="submit" name="save" class="btn btn-primary mb-4">Сохранить</button>

    <div>
        <small class="text-muted">Полная версия bCMS: <strong><?= htmlspecialchars($version) ?></strong></small>
    </div>
</form>

<script>
    // Bootstrap форма валидация
    (() => {
        'use strict'
        const forms = document.querySelectorAll('.needs-validation')
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        })
    })()
</script>