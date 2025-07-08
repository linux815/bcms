<!-- TinyMCE -->
<script src="/bcms/tinymce/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector: "textarea",
        height: 360,
        language: "ru",
        plugins: "image link lists code preview fullscreen",
        toolbar: "undo redo | styles | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist | link image | preview code fullscreen",
        menubar: false,
        branding: false,
        automatic_uploads: true,
        images_upload_url: "upload_image.php",
        file_picker_types: 'image',
        image_title: true,
        file_picker_callback: function (cb, value, meta) {
            if (meta.filetype === 'image') {
                const input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/*');
                input.onchange = function () {
                    const file = this.files[0];
                    const formData = new FormData();
                    formData.append('file', file);

                    fetch('upload_image.php', {
                        method: 'POST',
                        body: formData
                    })
                        .then(response => response.json())
                        .then(data => cb(data.location))
                        .catch(() => alert('Ошибка загрузки изображения'));
                };
                input.click();
            }
        }
    });
</script>

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-light border-bottom">
            <h5 class="mb-0">Редактирование страницы</h5>
        </div>
        <div class="card-body">
            <?php
            if (!empty($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php
            endif; ?>

            <form method="post">
                <div class="mb-3">
                    <label for="title" class="form-label">Название страницы</label>
                    <input type="text" class="form-control" id="title" name="title"
                           value="<?= htmlspecialchars($page['title'] ?? '') ?>" required>
                    <div class="form-text">Это название будет отображаться в меню сайта.</div>
                </div>

                <div class="mb-3">
                    <label for="modules" class="form-label">Подключить модуль</label>
                    <div class="d-flex flex-wrap gap-2">
                        <select id="modules" name="modules" class="form-select w-auto">
                            <option disabled selected>Выберите модуль</option>
                            <option value="news">Новости</option>
                            <option value="ghost">Гостевая книга</option>
                            <option value="review">Обратная связь</option>
                            <option value="disable">Отключить все</option>
                        </select>
                        <input type="hidden" id="page-id" name="hide" value="<?= (int)($_GET['id'] ?? 0) ?>">
                        <button type="button" onclick="sendModule()" class="btn btn-outline-secondary">Добавить</button>
                    </div>
                    <div id="result" class="form-text mt-1"></div>
                </div>

                <div class="mb-3">
                    <label for="content" class="form-label">Содержимое страницы</label>
                    <textarea name="content" id="content"><?= htmlspecialchars($page['text'] ?? '') ?></textarea>
                </div>

                <div class="text-end">
                    <button type="submit" name="SaveInfo" class="btn btn-success">
                        Сохранить
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function sendModule() {
        const module = document.getElementById('modules').value;
        const id = document.getElementById('page-id').value;

        if (!module || !id) return;

        fetch('index.php?c=jquery', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'module=' + encodeURIComponent(module) + '&id=' + encodeURIComponent(id)
        })
            .then(response => response.text())
            .then(html => {
                document.getElementById('result').innerHTML = html;
            })
            .catch(() => {
                document.getElementById('result').textContent = 'Ошибка при добавлении модуля';
            });
    }
</script>