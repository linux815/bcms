<div class="container my-5">
    <div class="card shadow-sm mx-auto" style="max-width: 480px;">
        <div class="card-header bg-danger text-white">
            <h5 class="mb-0">Подтверждение действия</h5>
        </div>
        <div class="card-body">
            <p class="fs-5"><?= htmlspecialchars($char) ?></p>
            <form method="post" class="d-flex justify-content-center gap-3">
                <button type="submit" name="Yes" value="Yes" class="btn btn-danger d-flex align-items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                         class="bi bi-check-lg" viewBox="0 0 16 16">
                        <path d="M13.485 1.785a1 1 0 0 1 1.415 1.415l-8.5 8.5a1 1 0 0 1-1.414 0l-4.5-4.5a1 1 0 0 1 1.414-1.414L6 9.086l7.485-7.3z"/>
                    </svg>
                    Да
                </button>
                <button type="submit" name="No" value="No" class="btn btn-secondary d-flex align-items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                         class="bi bi-x-lg" viewBox="0 0 16 16">
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                    </svg>
                    Нет
                </button>
            </form>
        </div>
    </div>
</div>