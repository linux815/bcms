<?php
// $error - null|1|2 (капча не пройдена, успех)
// $captchaNum1, $captchaNum2 - числа для капчи
?>

<div class="container py-4">
    <h2>Обратная связь</h2>

    <?php
    if ($error === 1): ?>
        <div class="alert alert-danger" role="alert">
            Неверный ответ на капчу. Пожалуйста, попробуйте снова.
        </div>
    <?php
    elseif ($error === 2): ?>
        <div class="alert alert-success" role="alert">
            Спасибо! Ваше сообщение успешно отправлено.
        </div>
    <?php
    endif; ?>

    <form method="post" action="" class="needs-validation" novalidate>
        <div class="mb-3">
            <label for="name" class="form-label">Имя <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="name" name="name" required
                   value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
            <div class="invalid-feedback">Пожалуйста, введите ваше имя.</div>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
            <input type="email" class="form-control" id="email" name="email" required
                   value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
            <div class="invalid-feedback">Пожалуйста, введите корректный email.</div>
        </div>

        <div class="mb-3">
            <label for="subject" class="form-label">Тема <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="subject" name="subject" required
                   value="<?= htmlspecialchars($_POST['subject'] ?? '') ?>">
            <div class="invalid-feedback">Пожалуйста, введите тему сообщения.</div>
        </div>

        <div class="mb-3">
            <label for="text" class="form-label">Сообщение <span class="text-danger">*</span></label>
            <textarea class="form-control" id="text" name="text" rows="5" required><?= htmlspecialchars(
                    $_POST['text'] ?? '',
                ) ?></textarea>
            <div class="invalid-feedback">Пожалуйста, введите текст сообщения.</div>
        </div>

        <!-- Математическая капча -->
        <div class="mb-3">
            <label for="captcha" class="form-label">Сколько будет <?= $captchaNum1 ?> + <?= $captchaNum2 ?>? <span
                        class="text-danger">*</span></label>
            <input type="number" class="form-control" id="captcha" name="captcha" required>
            <div class="invalid-feedback">Пожалуйста, ответьте на вопрос.</div>
        </div>

        <button type="submit" class="btn btn-primary">Отправить сообщение</button>
    </form>
</div>

<script>
    // Bootstrap 5 форма валидация
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