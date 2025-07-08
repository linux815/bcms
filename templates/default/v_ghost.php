<div class="container mt-4">

    <?php
    if ($error === 2): ?>
        <div class="alert alert-success" role="alert">Сообщение отправлено.</div>
    <?php
    elseif ($error === 1): ?>
        <div class="alert alert-danger" role="alert">Ошибка проверки капчи. Попробуйте еще раз.</div>
    <?php
    endif; ?>

    <form method="post" action="#" id="contactform" class="mb-4">
        <div class="mb-3 row">
            <label for="name" class="col-sm-2 col-form-label">Ваше имя:</label>
            <div class="col-sm-10">
                <input type="text" name="name" id="name" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>"
                       class="form-control" required/>
            </div>
        </div>

        <div class="mb-3 row">
            <label for="email" class="col-sm-2 col-form-label">E-mail:</label>
            <div class="col-sm-10">
                <input type="email" name="email" id="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                       class="form-control" required/>
            </div>
        </div>

        <div class="mb-3 row">
            <label for="url" class="col-sm-2 col-form-label">URL:</label>
            <div class="col-sm-10">
                <input type="url" name="url" id="url" value="<?= htmlspecialchars($_POST['url'] ?? '') ?>"
                       class="form-control"/>
            </div>
        </div>

        <div class="mb-3 row">
            <label for="text" class="col-sm-2 col-form-label">Сообщение:</label>
            <div class="col-sm-10">
                <textarea name="text" id="text" rows="5" class="form-control" required><?= htmlspecialchars(
                        $_POST['text'] ?? '',
                    ) ?></textarea>
            </div>
        </div>

        <div class="mb-3 row align-items-center">
            <label for="captcha" class="col-sm-2 col-form-label"><strong>Капча:</strong></label>
            <div class="col-sm-6">
                <input type="text" name="captcha" id="captcha" class="form-control"
                       placeholder="<?= htmlspecialchars($captcha_question) ?>" required/>
            </div>
        </div>

        <div class="mb-3 row">
            <div class="offset-sm-2 col-sm-10">
                <button type="submit" class="btn btn-primary">Отправить сообщение</button>
            </div>
        </div>
    </form>

    <hr/>

    <h4>Отзывы пользователей</h4>

    <?php
    foreach ($ghost as $comment): ?>
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <strong><?= htmlspecialchars($comment['title']) ?></strong><br/>
                    <small class="text-muted"><?= htmlspecialchars($comment['date']) ?></small>
                </div>
                <div>
                    <a href="mailto:<?= htmlspecialchars($comment['email']) ?>" class="me-3">Email</a>
                    <a href="<?= htmlspecialchars($comment['url']) ?>" target="_blank"
                       rel="noopener noreferrer">Сайт</a>
                    <?php
                    if (!empty($user) && !empty($user[0])): ?>
                        &nbsp;|&nbsp;
                        <a href="index.php?c=view&id=<?= (int)($_GET['id'] ?? 30) ?>&ghost=<?= (int)$comment['id'] ?>"
                           class="text-danger"
                           onclick="return confirm('Удалить сообщение?');">Удалить</a>
                    <?php
                    endif; ?>
                </div>
            </div>
            <div class="card-body">
                <p><?= nl2br(htmlspecialchars($comment['message'])) ?></p>
            </div>
        </div>
    <?php
    endforeach; ?>

</div>