<div class="login-container container">
    <div class="row w-100 gx-4 justify-content-center">
        <div class="col-md-5 col-lg-4">
            <div class="card login-card h-100 d-flex flex-column justify-content-center">
                <h2>Авторизация</h2>

                <?php
                if (!empty($error)): ?>
                    <div class="alert alert-danger" role="alert">
                        Неверный логин или пароль! Попробуйте еще раз.
                    </div>
                <?php
                endif; ?>

                <form method="post" action="" novalidate class="needs-validation">
                    <div class="mb-3">
                        <label for="login" class="form-label">Логин</label>
                        <input type="text" id="login" name="login" class="form-control" required autofocus>
                        <div class="invalid-feedback">
                            Пожалуйста, введите логин.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Пароль</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                        <div class="invalid-feedback">
                            Пожалуйста, введите пароль.
                        </div>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="remember" name="remember" checked>
                        <label class="form-check-label" for="remember">Запомнить меня</label>
                    </div>

                    <button type="submit" class="btn btn-login w-100 py-2">Войти</button>
                </form>
            </div>
        </div>

        <div class="col-md-5 col-lg-4">
            <div class="card welcome-card h-100">
                <h3>Добро пожаловать</h3>
                <ol class="welcome-list">
                    <li>

                        <a href="https://github.com/linux815/bcms" target="_blank" rel="noopener noreferrer">
                            <i class="bi bi-github"></i>&nbsp; Страница проекта (Github)
                        </a>
                    </li>
                    <li>

                        <a href="https://github.com/linux815/bcms/releases" target="_blank" rel="noopener noreferrer">
                            <i class="bi bi-clock-history"></i>&nbsp; История изменений
                        </a>
                    </li>
                    <li>
                        <a href="mailto:ivan.bazhenov@gmail.com?subject=Вопрос по bCMS">
                            <i class="bi bi-envelope-fill"></i>&nbsp; Написать письмо
                        </a>
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>

<script>
    (() => {
        'use strict';
        const forms = document.querySelectorAll('.needs-validation');
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    })();
</script>