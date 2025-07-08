<div class="container my-5">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-bottom">
            <h4 class="mb-0">Добавление новой страницы</h4>
        </div>

        <div class="card-body">
            <?php
            if (!empty($error)): ?>
                <div class="alert alert-danger mb-4" role="alert">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php
            endif; ?>

            <form method="post" class="needs-validation" novalidate>
                <div class="mb-4">
                    <label for="title" class="form-label">Заголовок страницы</label>
                    <input
                            type="text"
                            name="title"
                            id="title"
                            class="form-control"
                            placeholder="Введите название страницы"
                            required
                    >
                    <div class="form-text">Это название будет отображаться в меню сайта.</div>
                </div>

                <div class="mb-4">
                    <label for="hide" class="form-label">Сделать страницу скрытой?</label>
                    <select name="hide" id="hide" class="form-select">
                        <option value="1">Да</option>
                        <option value="0" selected>Нет</option>
                    </select>
                </div>

                <div class="d-flex gap-2">
                    <button type="reset" class="btn btn-outline-secondary">Сброс</button>
                    <button type="submit" class="btn btn-success">Добавить страницу</button>
                </div>
            </form>
        </div>
    </div>
</div>