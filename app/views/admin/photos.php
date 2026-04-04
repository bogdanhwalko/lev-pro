<?php
/** @var yii\web\View $this */
/** @var app\models\Project $model */

use yii\helpers\Html;

$this->title = $model->name;
$images = $model->getImages();
?>

<div class="d-flex align-items-center mb-3 gap-2">
    <?= Html::a(
        '<i class="fa fa-arrow-left"></i>',
        ['/admin/index'],
        ['class' => 'btn btn-outline-secondary', 'title' => 'Назад', 'encode' => false]
    ) ?>
    <div>
        <h5 class="mb-0 fw-bold"><?= Html::encode($model->name) ?></h5>
        <small class="text-muted"><i class="fa fa-tag"></i> <?= Html::encode($model->category) ?></small>
    </div>
</div>

<div class="row g-3">

    <!-- Upload panel -->
    <div class="col-12 col-lg-4">
        <div class="card">
            <div class="card-header">
                <i class="fa fa-cloud-upload"></i> Завантажити фото
            </div>
            <div class="card-body d-flex flex-column p-3">

                <?= Html::beginForm(['/admin/upload', 'id' => $model->id], 'post', [
                    'enctype' => 'multipart/form-data',
                    'id' => 'upload-form',
                ]) ?>

                <div id="drop-zone"
                     onclick="document.getElementById('photo-input').click()"
                     role="button" tabindex="0" aria-label="Натисніть або перетягніть фото">
                    <i class="fa fa-photo fa-3x text-muted mb-3"></i>
                    <div class="fw-semibold text-muted">Натисніть або перетягніть</div>
                    <div class="text-muted small mt-1">JPG · PNG · WEBP</div>
                </div>

                <input type="file" id="photo-input" name="photos[]"
                       multiple accept=".jpg,.jpeg,.png,.webp"
                       style="display:none" onchange="previewFiles(this)">

                <div id="preview-list" class="d-flex flex-wrap gap-2 mt-3"></div>
                <div id="file-count" class="text-muted mt-2" style="font-size:.82rem;display:none"></div>

                <button type="submit" id="submit-btn" class="btn btn-primary mt-3 w-100" style="display:none">
                    <i class="fa fa-cloud-upload"></i> Завантажити
                </button>

                <?= Html::endForm() ?>
            </div>
        </div>
    </div>

    <!-- Photo grid -->
    <div class="col-12 col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fa fa-th"></i> Фотографії</span>
                <span class="badge bg-secondary rounded-pill"><?= count($images) ?></span>
            </div>
            <div class="card-body p-3">
                <?php if (empty($images)): ?>
                    <div class="text-center text-muted py-4">
                        <i class="fa fa-picture-o fa-3x d-block mb-2 text-secondary"></i>
                        Фото ще не завантажені
                    </div>
                <?php else: ?>
                    <div class="d-flex flex-wrap gap-2">
                        <?php foreach ($images as $imagePath): ?>
                            <?php $filename = basename($imagePath); ?>
                            <div class="photo-card">
                                <img src="<?= Html::encode($model->getImageUrl($filename)) ?>"
                                     alt="" class="photo-thumb" loading="lazy">
                                <?= Html::beginForm(['/admin/delete-photo', 'id' => $model->id], 'post') ?>
                                <?= Html::hiddenInput('file', $filename) ?>
                                <?= Html::submitButton(
                                    '<i class="fa fa-times"></i>',
                                    [
                                        'class' => 'del-btn',
                                        'title' => 'Видалити',
                                        'encode' => false,
                                        'data-confirm' => 'Видалити це фото?',
                                    ]
                                ) ?>
                                <?= Html::endForm() ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

</div>

<style>
#drop-zone {
    border: 2px dashed #ced4da;
    border-radius: 10px;
    padding: 36px 16px;
    text-align: center;
    cursor: pointer;
    background: #fafbfc;
    transition: border-color .2s, background .2s;
    user-select: none;
}
#drop-zone:hover, #drop-zone.over {
    border-color: #0d6efd;
    background: #eef3ff;
}
@media (max-width: 575px) { #drop-zone { padding: 28px 12px; } }
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
    const btn     = document.getElementById('submit-btn');
    list.innerHTML = '';
    const files = Array.from(input.files);
    if (!files.length) { btn.style.display = 'none'; countEl.style.display = 'none'; return; }

    files.slice(0, 10).forEach(file => {
        const reader = new FileReader();
        reader.onload = e => {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.style.cssText = 'width:60px;height:45px;object-fit:cover;border-radius:6px;border:1px solid #dee2e6;flex-shrink:0';
            list.appendChild(img);
        };
        reader.readAsDataURL(file);
    });
    if (files.length > 10) {
        const more = document.createElement('div');
        more.style.cssText = 'display:flex;align-items:center;color:#888;font-size:.85rem';
        more.textContent = '+' + (files.length - 10);
        list.appendChild(more);
    }
    countEl.textContent = 'Вибрано: ' + files.length + ' файл(ів)';
    countEl.style.display = 'block';
    btn.style.display = 'block';
}
</script>
