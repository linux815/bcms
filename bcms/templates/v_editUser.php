<!-- Подключение локального TinyMCE 7.9.1 -->
<script src="/bcms/tinymce/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector: 'textarea[name="avatar"]',
        height: 300,
        menubar: false,
        plugins: 'image code lists link preview',
        toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | bullist numlist outdent indent | image | code',
        language: 'ru',
        skin: 'oxide',
        content_css: 'default',
        relative_urls: false,
        remove_script_host: false,
        document_base_url: "/bcms/",
        automatic_uploads: true,
        images_upload_url: '/bcms/upload_image.php',
        images_upload_handler: function (blobInfo) {
            return new Promise(function (resolve, reject) {
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '/bcms/upload_image.php');
                xhr.onload = function () {
                    if (xhr.status !== 200) {
                        reject('HTTP Error: ' + xhr.status);
                        return;
                    }
                    var json = JSON.parse(xhr.responseText);
                    if (!json || typeof json.location != 'string') {
                        reject('Invalid JSON: ' + xhr.responseText);
                        return;
                    }
                    resolve(json.location);
                };
                xhr.onerror = function () {
                    reject('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
                };
                var formData = new FormData();
                formData.append('file', blobInfo.blob(), blobInfo.filename());
                xhr.send(formData);
            });
        }
    });
</script>

<div class="container my-4">
    <h2 class="mb-4">Редактирование пользователя</h2>

    <?php
    if (!empty($error)): ?>
        <div class="alert alert-danger">Пароли не совпадают! Попробуйте еще раз.</div>
    <?php
    endif; ?>

    <form method="post" class="needs-validation" novalidate>
        <div class="row g-3">
            <div class="col-md-6">
                <label for="login" class="form-label">Логин</label>
                <input type="text" id="login" class="form-control" value="<?= htmlspecialchars($userID['login']) ?>"
                       disabled>
            </div>

            <div class="col-md-6">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-control"
                       value="<?= htmlspecialchars($userID['email']) ?>">
            </div>

            <div class="col-md-6">
                <label for="password" class="form-label">Пароль</label>
                <input type="password" id="password" name="password" class="form-control">
            </div>

            <div class="col-md-6">
                <label for="password_apply" class="form-label">Подтверждение пароля</label>
                <input type="password" id="password_apply" name="password_apply" class="form-control">
            </div>

            <div class="col-md-4">
                <label for="name" class="form-label">Имя</label>
                <input type="text" id="name" name="name" class="form-control"
                       value="<?= htmlspecialchars($userID['name']) ?>">
            </div>

            <div class="col-md-4">
                <label for="surname" class="form-label">Фамилия</label>
                <input type="text" id="surname" name="surname" class="form-control"
                       value="<?= htmlspecialchars($userID['surname']) ?>">
            </div>

            <div class="col-md-4">
                <label for="lastname" class="form-label">Отчество</label>
                <input type="text" id="lastname" name="lastname" class="form-control"
                       value="<?= htmlspecialchars($userID['lastname']) ?>">
            </div>

            <div class="col-md-4">
                <label for="sex" class="form-label">Пол</label>
                <select name="sex" id="sex" class="form-select">
                    <option value="" disabled <?= empty($userID['sex']) ? 'selected' : '' ?>>Выберите пол</option>
                    <option value="Мужской" <?= $userID['sex'] === 'Мужской' ? 'selected' : '' ?>>Мужской</option>
                    <option value="Женский" <?= $userID['sex'] === 'Женский' ? 'selected' : '' ?>>Женский</option>
                    <option value="Средний" <?= $userID['sex'] === 'Средний' ? 'selected' : '' ?>>Средний</option>
                </select>
            </div>

            <div class="col-md-4">
                <label for="birth_date" class="form-label">Дата рождения</label>
                <input type="text" id="birth_date" name="birth_date" class="form-control"
                       value="<?= htmlspecialchars($userID['birth_date']) ?>">
            </div>

            <div class="col-md-4">
                <label for="city" class="form-label">Родной город</label>
                <input type="text" id="city" name="city" class="form-control"
                       value="<?= htmlspecialchars($userID['city']) ?>">
            </div>

            <div class="col-md-4">
                <label for="mobile_phone" class="form-label">Мобильный телефон</label>
                <input type="text" id="mobile_phone" name="mobile_phone" class="form-control"
                       value="<?= htmlspecialchars($userID['mobile_phone']) ?>">
            </div>

            <div class="col-md-4">
                <label for="work_phone" class="form-label">Рабочий телефон</label>
                <input type="text" id="work_phone" name="work_phone" class="form-control"
                       value="<?= htmlspecialchars($userID['work_phone']) ?>">
            </div>

            <div class="col-md-4">
                <label for="skype" class="form-label">Skype</label>
                <input type="text" id="skype" name="skype" class="form-control"
                       value="<?= htmlspecialchars($userID['skype']) ?>">
            </div>

            <div class="col-12">
                <label for="avatar" class="form-label">Аватар (HTML или &lt;img&gt; код)</label>
                <textarea id="avatar" name="avatar" class="form-control" rows="3"><?= htmlspecialchars(
                        $userID['avatar'],
                    ) ?></textarea>
            </div>

            <div class="col-12 d-flex justify-content-between align-items-center mt-4">
                <button type="submit" name="SaveInfo" class="btn btn-primary">
                    <img src="images/icons/tick.png" alt="Save" class="me-2">Сохранить
                </button>
                <input type="reset" class="btn btn-outline-secondary" value="Сбросить">
                <button type="button" class="btn btn-danger" onclick="history.back()">
                    <img src="images/icons/cancel.png" alt="Cancel" class="me-2">Назад
                </button>
            </div>
        </div>
    </form>
</div>