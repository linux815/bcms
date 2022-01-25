<!-- TinyMCE -->
<script src="tinymce/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector: "textarea",
        height: 350,
        language: "ru",
        plugins: [
            "advlist autolink lists link image charmap preview anchor",
            "searchreplace wordcount visualblocks fullscreen",
            "insertdatetime media table code"
        ],
        toolbar: "undo redo | bold italic | alignleft aligncenter alignright | bullist numlist | link image | preview code fullscreen",
        image_title: true,
        automatic_uploads: true,
        images_upload_url: "upload_image.php",
        file_picker_types: 'image',
        file_picker_callback: function (cb, value, meta) {
            if (meta.filetype === 'image') {
                const input = document.createElement('input');
                input.type = 'file';
                input.accept = 'image/*';
                input.onchange = function () {
                    const file = this.files[0];
                    const formData = new FormData();
                    formData.append('file', file);

                    fetch('upload_image.php', {
                        method: 'POST',
                        body: formData
                    })
                        .then(res => res.json())
                        .then(data => cb(data.location))
                        .catch(() => alert('Ошибка загрузки изображения'));
                };
                input.click();
            }
        }
    });
</script>

<style>
    .form-wrapper {
        margin-top: 24px;
        margin-bottom: 24px;
    }

    .form-card {
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
        border-radius: 0.75rem;
        padding: 2rem;
        background-color: #fff;
    }

    .form-label {
        margin-bottom: 0.25rem;
        font-weight: 500;
    }

    .form-control,
    textarea {
        font-size: 0.95rem;
        padding: 0.45rem 0.75rem;
    }

    .btn {
        padding: 0.45rem 1.5rem;
        font-size: 0.95rem;
    }
</style>

<div class="container form-wrapper" style="max-width: 768px;">
    <div class="form-card">
        <h5 class="mb-3 text-center">Редактирование новости</h5>

        <form method="post">
            <div class="mb-3">
                <label for="title" class="form-label">Заголовок</label>
                <input type="text" id="title" name="title" class="form-control"
                       value="<?= htmlspecialchars($news['title'] ?? '') ?>" required>
            </div>

            <div class="mb-3">
                <label for="content" class="form-label">Текст новости</label>
                <textarea id="content" name="content"><?= htmlspecialchars($news['text'] ?? '') ?></textarea>
            </div>

            <div class="text-center mt-3">
                <button type="submit" name="SaveInfo" class="btn btn-primary shadow-sm">
                    Сохранить
                </button>
            </div>
        </form>
    </div>
</div>