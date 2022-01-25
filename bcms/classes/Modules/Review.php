<?php
/*
 * Review.php — модуль "Обратная связь"
 */

namespace bcms\classes\Modules;

use bcms\classes\BaseClass\Base;
use bcms\classes\Database\ReviewModel;

class Review extends Base
{
    private array $reviews = [];
    private ?array $reviewId = null;

    protected function onInput(): void
    {
        parent::onInput();

        $database = new ReviewModel();
        $this->title = 'Обратная связь - ' . $this->title;

        // Удаление отзыва
        $deleteId = filter_input(INPUT_GET, 'delete', FILTER_VALIDATE_INT);
        if ($deleteId) {
            $database->deleteReview($deleteId);
            header('Location: index.php?c=review');
            exit;
        }

        // Просмотр конкретного отзыва
        $viewId = filter_input(INPUT_GET, 'view', FILTER_VALIDATE_INT);
        if ($viewId) {
            $this->reviewId = $database->selectReviewId($viewId);
        }

        // Получение всех отзывов
        $this->reviews = $database->selectReview();
    }

    protected function onOutput(): void
    {
        $vars = [
            'reviews' => $this->reviews,
            'review_id' => $this->reviewId,
        ];
        $this->content = $this->template('templates/v_review.php', $vars);
        parent::onOutput();
    }
}