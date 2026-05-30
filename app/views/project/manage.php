<?php
/** @var yii\web\View $this */
/** @var app\models\WorkProject $model */
/** @var app\models\WorkProjectPost[] $posts */

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

$this->title = $model->title;
?>

<div class="d-flex align-items-center mb-3 gap-2 flex-wrap">
    <?= Html::a(
        '<i class="fa fa-arrow-left"></i>',
        ['/project/index'],
        ['class' => 'btn btn-outline-secondary', 'title' => 'Назад', 'encode' => false]
    ) ?>
    <div class="flex-grow-1 min-w-0">
        <h5 class="mb-0 fw-bold text-truncate"><?= Html::encode($model->title) ?></h5>
        <small class="text-muted">
            <?php if ($model->comments_enabled): ?>
                <i class="fa fa-comments text-success"></i> Коментарі увімкнені
            <?php else: ?>
                <i class="fa fa-comments-o"></i> Коментарі вимкнені
            <?php endif; ?>
        </small>
    </div>
    <?= Html::a('<i class="fa fa-external-link"></i> Сторінка', $model->getUrl(), [
        'class' => 'btn btn-sm btn-outline-secondary', 'target' => '_blank', 'encode' => false,
    ]) ?>
    <?= Html::a('<i class="fa fa-pencil"></i>', ['/project/update', 'id' => $model->id], [
        'class' => 'btn btn-sm btn-outline-secondary', 'title' => 'Налаштування', 'encode' => false,
    ]) ?>
</div>

<!-- Cover -->
<?php $cover = $model->getCoverImage(); ?>
<div class="card mb-4">
    <div class="card-header"><i class="fa fa-image"></i> Обкладинка сторінки</div>
    <div class="card-body p-3">
        <div class="d-flex flex-wrap align-items-center gap-3">
            <?php if ($cover): ?>
                <img src="<?= Html::encode($cover) ?>" alt=""
                     style="width:200px;height:112px;object-fit:cover;border-radius:8px;border:1px solid #e3e8ef">
            <?php else: ?>
                <div style="width:200px;height:112px;background:#eef0f3;border-radius:8px;display:flex;align-items:center;justify-content:center;color:#aaa">
                    <i class="fa fa-image fa-2x"></i>
                </div>
            <?php endif; ?>
            <div class="d-flex flex-column gap-2">
                <small class="text-muted">Показується вгорі публічної сторінки. Рекомендовано широке фото (16:9).</small>
                <div class="d-flex gap-2 flex-wrap">
                    <?= Html::beginForm(['/project/cover', 'id' => $model->id], 'post', ['enctype' => 'multipart/form-data', 'class' => 'd-flex gap-2 flex-wrap']) ?>
                    <input type="file" name="cover" accept=".jpg,.jpeg,.png,.webp" class="form-control form-control-sm" style="max-width:240px" required>
                    <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-upload"></i> <?= $cover ? 'Замінити' : 'Завантажити' ?></button>
                    <?= Html::endForm() ?>
                    <?php if ($cover): ?>
                        <?= Html::beginForm(['/project/cover-delete', 'id' => $model->id], 'post') ?>
                        <?= Html::submitButton('<i class="fa fa-trash"></i> Видалити', [
                            'class' => 'btn btn-sm btn-outline-danger', 'encode' => false,
                            'data-confirm' => 'Видалити обкладинку?',
                        ]) ?>
                        <?= Html::endForm() ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add post -->
<div class="card mb-4">
    <div class="card-header"><i class="fa fa-plus"></i> Новий запис</div>
    <div class="card-body p-3">
        <?= Html::beginForm(['/project/post-create', 'id' => $model->id], 'post', [
            'enctype' => 'multipart/form-data',
            'id' => 'post-form',
        ]) ?>
            <textarea id="post-body" name="body" class="form-control mb-3" rows="4"
                      placeholder="Текст запису (необов'язково, якщо є фото)"></textarea>

            <div id="drop-zone"
                 onclick="document.getElementById('photo-input').click()"
                 role="button" tabindex="0" aria-label="Натисніть або перетягніть фото">
                <i class="fa fa-photo fa-2x text-muted mb-2"></i>
                <div class="fw-semibold text-muted">Додати фото — натисніть або перетягніть</div>
                <div class="text-muted small mt-1">JPG · PNG · WEBP · кілька файлів</div>
            </div>

            <input type="file" id="photo-input" name="photos[]"
                   multiple accept=".jpg,.jpeg,.png,.webp"
                   style="display:none" onchange="previewFiles(this)">

            <div id="preview-list" class="d-flex flex-wrap gap-2 mt-3"></div>
            <div id="file-count" class="text-muted mt-2" style="font-size:.82rem;display:none"></div>

            <button type="submit" class="btn btn-primary mt-3">
                <i class="fa fa-check"></i> Додати запис
            </button>
        <?= Html::endForm() ?>
    </div>
</div>

<!-- Timeline -->
<h6 class="text-uppercase text-muted fw-bold mb-3" style="font-size:.75rem;letter-spacing:.06em">
    <i class="fa fa-clock-o"></i> Таймлайн (<?= count($posts) ?>)
</h6>

<?php if (empty($posts)): ?>
    <div class="card"><div class="card-body text-center text-muted py-4">
        Записів ще немає — додайте перший вище.
    </div></div>
<?php else: ?>
    <?php foreach ($posts as $post): ?>
        <?php $images = $post->getImages(); ?>
        <div class="card mb-3">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                    <small class="text-muted">
                        <i class="fa fa-calendar"></i> <?= date('d.m.Y H:i', $post->created_at) ?>
                    </small>
                    <?= Html::beginForm(['/project/post-delete', 'id' => $post->id], 'post', ['style' => 'display:inline']) ?>
                    <?= Html::submitButton('<i class="fa fa-trash"></i>', [
                        'class' => 'btn btn-sm btn-outline-danger', 'title' => 'Видалити запис', 'encode' => false,
                        'data-confirm' => 'Видалити цей запис з фото та коментарями?',
                    ]) ?>
                    <?= Html::endForm() ?>
                </div>

                <?php if ($post->body): ?>
                    <div class="mb-3 post-body-html"><?= HtmlPurifier::process($post->body) ?></div>
                <?php endif; ?>

                <?php if (!empty($images)): ?>
                    <div class="d-flex flex-wrap gap-2 mb-2">
                        <?php foreach ($images as $imagePath): ?>
                            <?php $filename = basename($imagePath); ?>
                            <div class="photo-card">
                                <img src="<?= Html::encode($post->getImageUrl($filename)) ?>"
                                     alt="" class="photo-thumb" loading="lazy">
                                <?= Html::beginForm(['/project/photo-delete', 'id' => $post->id], 'post') ?>
                                <?= Html::hiddenInput('file', $filename) ?>
                                <?= Html::submitButton('<i class="fa fa-times"></i>', [
                                    'class' => 'del-btn', 'title' => 'Видалити', 'encode' => false,
                                    'data-confirm' => 'Видалити це фото?',
                                ]) ?>
                                <?= Html::endForm() ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- Comments -->
                <?php $comments = $post->comments; ?>
                <div class="border-top pt-2 mt-2">
                    <small class="text-muted d-block mb-2">
                        <i class="fa fa-comment-o"></i> Коментарі: <?= count($comments) ?>
                    </small>
                    <?php foreach ($comments as $comment): ?>
                        <div class="mb-2 p-2 rounded" style="background:#f6f8fa">
                            <div class="d-flex justify-content-between align-items-start gap-2">
                                <div class="min-w-0">
                                    <div class="fw-semibold" style="font-size:.85rem">
                                        <?= Html::encode($comment->author_name) ?>
                                        <span class="text-muted fw-normal">· <?= date('d.m.Y H:i', $comment->created_at) ?></span>
                                    </div>
                                    <div style="font-size:.85rem;white-space:pre-wrap"><?= Html::encode($comment->body) ?></div>
                                </div>
                                <?= Html::beginForm(['/project/comment-delete', 'id' => $comment->id], 'post', ['style' => 'display:inline']) ?>
                                <?= Html::submitButton('<i class="fa fa-times"></i>', [
                                    'class' => 'btn btn-sm btn-outline-danger', 'title' => 'Видалити', 'encode' => false,
                                    'data-confirm' => 'Видалити коментар?',
                                ]) ?>
                                <?= Html::endForm() ?>
                            </div>

                            <!-- Admin reply -->
                            <?= Html::beginForm(['/project/comment-reply', 'id' => $comment->id], 'post', ['class' => 'mt-2']) ?>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text"><i class="fa fa-reply"></i></span>
                                <textarea name="reply" class="form-control" rows="1"
                                          placeholder="Відповідь від LevPro (залиште порожнім, щоб прибрати)"><?= Html::encode((string) $comment->admin_reply) ?></textarea>
                                <button type="submit" class="btn btn-outline-primary">Зберегти</button>
                            </div>
                            <?php if ($comment->admin_reply_at): ?>
                                <small class="text-muted">Відповідь від <?= date('d.m.Y H:i', $comment->admin_reply_at) ?></small>
                            <?php endif; ?>
                            <?= Html::endForm() ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<style>
#drop-zone {
    border: 2px dashed #ced4da;
    border-radius: 10px;
    padding: 28px 16px;
    text-align: center;
    cursor: pointer;
    background: #fafbfc;
    transition: border-color .2s, background .2s;
    user-select: none;
}
#drop-zone:hover, #drop-zone.over { border-color: #0d6efd; background: #eef3ff; }
</style>

<script>
const dropZone = document.getElementById('drop-zone');
const fileInput = document.getElementById('photo-input');

dropZone.addEventListener('keydown', e => { if (e.key === 'Enter' || e.key === ' ') fileInput.click(); });
['dragenter','dragover'].forEach(ev => dropZone.addEventListener(ev, e => { e.preventDefault(); dropZone.classList.add('over'); }));
['dragleave','drop'].forEach(ev => dropZone.addEventListener(ev, () => dropZone.classList.remove('over')));
dropZone.addEventListener('drop', e => {
    e.preventDefault();
    const dt = new DataTransfer();
    Array.from(e.dataTransfer.files).forEach(f => dt.items.add(f));
    fileInput.files = dt.files;
    previewFiles(fileInput);
});

function previewFiles(input) {
    const list    = document.getElementById('preview-list');
    const countEl = document.getElementById('file-count');
    list.innerHTML = '';
    const files = Array.from(input.files);
    if (!files.length) { countEl.style.display = 'none'; return; }

    files.slice(0, 12).forEach(file => {
        const reader = new FileReader();
        reader.onload = e => {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.style.cssText = 'width:60px;height:45px;object-fit:cover;border-radius:6px;border:1px solid #dee2e6;flex-shrink:0';
            list.appendChild(img);
        };
        reader.readAsDataURL(file);
    });
    if (files.length > 12) {
        const more = document.createElement('div');
        more.style.cssText = 'display:flex;align-items:center;color:#888;font-size:.85rem';
        more.textContent = '+' + (files.length - 12);
        list.appendChild(more);
    }
    countEl.textContent = 'Вибрано: ' + files.length + ' файл(ів)';
    countEl.style.display = 'block';
}
</script>

<!-- HTML rich-text editor for the post body (CKEditor 5) -->
<style>
.ck-editor__editable { min-height: 140px; }
.post-body-html > :first-child { margin-top: 0; }
.post-body-html > :last-child { margin-bottom: 0; }
.post-body-html blockquote { border-left: 3px solid #ffba00; padding: 2px 12px; color: #555; margin: 0 0 10px; }
</style>
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script>
(function () {
    var ta = document.getElementById('post-body');
    var form = document.getElementById('post-form');
    if (!ta || typeof ClassicEditor === 'undefined') return; // graceful fallback to plain textarea

    ClassicEditor
        .create(ta, {
            toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', '|', 'undo', 'redo']
        })
        .then(function (editor) {
            // sync HTML back into the textarea before the form submits
            form.addEventListener('submit', function () { ta.value = editor.getData(); });
        })
        .catch(function (e) { console.error(e); });
})();
</script>
