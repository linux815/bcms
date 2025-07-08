<style>
    .action-btn {
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        background-color: transparent;
        border: none;
        box-shadow: none;
        color: #212529;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: background-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        cursor: pointer;
    }

    .action-btn:hover,
    .action-btn:focus {
        background-color: rgba(0, 123, 255, 0.12);
        box-shadow: 0 0 6px rgba(0, 123, 255, 0.3);
        color: #0d6efd;
        text-decoration: none;
        outline: none;
    }

    .action-btn img {
        display: block;
        width: 20px;
        height: 20px;
        pointer-events: none;
    }
</style>

<div class="container mt-4">
    <?php
    if (isset($_GET['view']) && !empty($review_id)): ?>
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Просмотр отзыва</h5>
            </div>
            <div class="card-body">
                <p><strong>Имя:</strong> <?= htmlspecialchars($review_id['name']) ?></p>
                <p><strong>Email:</strong>
                    <a href="mailto:<?= htmlspecialchars($review_id['email']) ?>?subject=RE: <?= htmlspecialchars(
                        $review_id['title'],
                    ) ?>">
                        <?= htmlspecialchars($review_id['email']) ?>
                    </a>
                </p>
                <p><strong>Тема:</strong> <?= htmlspecialchars($review_id['title']) ?></p>
                <p><strong>Сообщение:</strong><br><?= nl2br(htmlspecialchars($review_id['text'])) ?></p>
                <a href="index.php?c=review" class="btn btn-secondary mt-3">Назад к списку</a>
            </div>
        </div>
    <?php
    else: ?>
        <form method="post" class="mb-4">
            <h2 class="mb-4">Обратная связь</h2>

            <?php
            if (empty($reviews)): ?>
                <div class="alert alert-warning">Отзывы отсутствуют.</div>
            <?php
            else: ?>
                <div class="table-responsive shadow-sm rounded">
                    <table class="table table-hover table-striped align-middle mb-0 bg-white">
                        <thead class="table-light">
                        <tr>
                            <th>Имя</th>
                            <th>Email</th>
                            <th>Тема</th>
                            <th>Сообщение</th>
                            <th class="text-center">Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($reviews as $review): ?>
                            <?php
                            $text = strip_tags($review['text']);
                            $short = mb_strlen($text) > 200
                                ? mb_substr($text, 0, mb_strpos($text, ' ', 200)) . '...'
                                : $text;
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($review['name']) ?></td>
                                <td>
                                    <a href="mailto:<?= htmlspecialchars(
                                        $review['email'],
                                    ) ?>?subject=RE: <?= htmlspecialchars($review['title']) ?>">
                                        <?= htmlspecialchars($review['email']) ?>
                                    </a>
                                </td>
                                <td><?= htmlspecialchars($review['title']) ?></td>
                                <td><?= htmlspecialchars($short) ?></td>
                                <td class="text-center">
                                    <a href="index.php?c=review&view=<?= (int)$review['id_review'] ?>"
                                       title="Просмотреть" class="action-btn me-1" aria-label="Просмотреть отзыв">
                                        <img src="images/icons/file-find.png" alt="Просмотреть"/>
                                    </a>
                                    <a href="index.php?c=review&delete=<?= (int)$review['id_review'] ?>"
                                       title="Удалить"
                                       onclick="return confirm('Вы уверены, что хотите удалить этот отзыв?');"
                                       class="action-btn text-danger" aria-label="Удалить отзыв">
                                        <img src="images/icons/delete-file.png" alt="Удалить"/>
                                    </a>
                                </td>
                            </tr>
                        <?php
                        endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php
            endif; ?>
        </form>
    <?php
    endif; ?>
</div>