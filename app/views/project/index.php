<?php
/** @var yii\web\View $this */
/** @var app\models\WorkProject[] $projects */

use yii\helpers\Html;

$this->title = 'Проекти';
?>

<div class="d-flex justify-content-between align-items-center mb-3 gap-2">
    <h5 class="mb-0 fw-bold">Проекти</h5>
    <?= Html::a(
        '<i class="fa fa-plus"></i> Новий проект',
        ['/project/create'],
        ['class' => 'btn btn-primary btn-sm', 'encode' => false]
    ) ?>
</div>

<?php if (empty($projects)): ?>
    <div class="card">
        <div class="card-body text-center py-5 text-muted">
            <i class="fa fa-folder-open fa-3x d-block mb-3 text-secondary"></i>
            <p class="mb-2">Проектів ще немає.</p>
            <?= Html::a('Створіть перший проект', ['/project/create'], ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
<?php else: ?>
    <!-- Desktop table -->
    <div class="card project-table-wrap">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light" style="font-size:.82rem">
                    <tr>
                        <th>Назва проекту</th>
                        <th style="width:90px" class="text-center">Записів</th>
                        <th style="width:130px" class="text-center">Коментарі</th>
                        <th style="width:90px" class="text-center">Створено</th>
                        <th style="width:240px"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($projects as $project): ?>
                        <tr>
                            <td>
                                <strong><?= Html::encode($project->title) ?></strong>
                                <div class="d-flex align-items-center gap-2 mt-1">
                                    <input type="text" readonly
                                           class="form-control form-control-sm font-monospace"
                                           style="max-width:320px;font-size:.72rem"
                                           value="<?= Html::encode($project->getUrl()) ?>"
                                           onclick="this.select()">
                                    <button type="button" class="btn btn-sm btn-outline-secondary copy-link"
                                            data-link="<?= Html::encode($project->getUrl()) ?>" title="Копіювати">
                                        <i class="fa fa-copy"></i>
                                    </button>
                                    <?= Html::a('<i class="fa fa-external-link"></i>', $project->getUrl(), [
                                        'class' => 'btn btn-sm btn-outline-secondary', 'target' => '_blank',
                                        'title' => 'Відкрити', 'encode' => false,
                                    ]) ?>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-secondary rounded-pill"><?= $project->getPostCount() ?></span>
                            </td>
                            <td class="text-center">
                                <?= Html::beginForm(['/project/update', 'id' => $project->id], 'post', ['style' => 'display:inline']) ?>
                                <?= Html::hiddenInput('WorkProject[comments_enabled]', $project->comments_enabled ? 0 : 1) ?>
                                <?= Html::submitButton(
                                    $project->comments_enabled
                                        ? '<i class="fa fa-check-circle"></i> Увімкнені'
                                        : '<i class="fa fa-ban"></i> Вимкнені',
                                    [
                                        'class' => 'btn btn-sm ' . ($project->comments_enabled ? 'btn-success' : 'btn-outline-secondary'),
                                        'encode' => false,
                                        'title' => 'Перемкнути коментарі',
                                    ]
                                ) ?>
                                <?= Html::endForm() ?>
                            </td>
                            <td class="text-center text-muted" style="font-size:.8rem">
                                <?= date('d.m.Y', $project->created_at) ?>
                            </td>
                            <td>
                                <div class="d-flex gap-1 justify-content-end">
                                    <?= Html::a('<i class="fa fa-list"></i> Записи', ['/project/manage', 'id' => $project->id], [
                                        'class' => 'btn btn-sm btn-outline-primary', 'encode' => false,
                                    ]) ?>
                                    <?= Html::a('<i class="fa fa-pencil"></i>', ['/project/update', 'id' => $project->id], [
                                        'class' => 'btn btn-sm btn-outline-secondary', 'title' => 'Редагувати', 'encode' => false,
                                    ]) ?>
                                    <?= Html::beginForm(['/project/delete', 'id' => $project->id], 'post', ['style' => 'display:inline']) ?>
                                    <?= Html::submitButton('<i class="fa fa-trash"></i>', [
                                        'class' => 'btn btn-sm btn-outline-danger', 'title' => 'Видалити', 'encode' => false,
                                        'data-confirm' => 'Видалити проект «' . Html::encode($project->title) . '» з усіма записами, фото та коментарями?',
                                    ]) ?>
                                    <?= Html::endForm() ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Mobile cards -->
    <div class="project-card-mobile">
        <?php foreach ($projects as $project): ?>
            <div class="card mb-2">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start gap-2">
                        <strong class="me-auto"><?= Html::encode($project->title) ?></strong>
                        <span class="badge bg-secondary rounded-pill" title="Записів">
                            <i class="fa fa-list"></i> <?= $project->getPostCount() ?>
                        </span>
                    </div>
                    <div class="text-muted mt-1" style="font-size:.78rem">
                        <i class="fa fa-calendar"></i> <?= date('d.m.Y', $project->created_at) ?>
                    </div>

                    <div class="input-group input-group-sm mt-2">
                        <input type="text" readonly class="form-control font-monospace" style="font-size:.72rem"
                               value="<?= Html::encode($project->getUrl()) ?>" onclick="this.select()">
                        <button type="button" class="btn btn-outline-secondary copy-link"
                                data-link="<?= Html::encode($project->getUrl()) ?>" title="Копіювати">
                            <i class="fa fa-copy"></i>
                        </button>
                        <?= Html::a('<i class="fa fa-external-link"></i>', $project->getUrl(), [
                            'class' => 'btn btn-outline-secondary', 'target' => '_blank', 'encode' => false,
                        ]) ?>
                    </div>

                    <div class="mt-2">
                        <?= Html::beginForm(['/project/update', 'id' => $project->id], 'post', ['style' => 'display:inline']) ?>
                        <?= Html::hiddenInput('WorkProject[comments_enabled]', $project->comments_enabled ? 0 : 1) ?>
                        <?= Html::submitButton(
                            $project->comments_enabled
                                ? '<i class="fa fa-check-circle"></i> Коментарі увімкнені'
                                : '<i class="fa fa-ban"></i> Коментарі вимкнені',
                            [
                                'class' => 'btn btn-sm w-100 ' . ($project->comments_enabled ? 'btn-success' : 'btn-outline-secondary'),
                                'encode' => false,
                            ]
                        ) ?>
                        <?= Html::endForm() ?>
                    </div>

                    <div class="d-flex gap-2 mt-2">
                        <?= Html::a('<i class="fa fa-list"></i> Записи', ['/project/manage', 'id' => $project->id], [
                            'class' => 'btn btn-sm btn-outline-primary flex-fill text-center', 'encode' => false,
                        ]) ?>
                        <?= Html::a('<i class="fa fa-pencil"></i>', ['/project/update', 'id' => $project->id], [
                            'class' => 'btn btn-sm btn-outline-secondary', 'title' => 'Редагувати', 'encode' => false,
                        ]) ?>
                        <?= Html::beginForm(['/project/delete', 'id' => $project->id], 'post', ['style' => 'flex:0']) ?>
                        <?= Html::submitButton('<i class="fa fa-trash"></i>', [
                            'class' => 'btn btn-sm btn-outline-danger', 'encode' => false,
                            'data-confirm' => 'Видалити проект «' . Html::encode($project->title) . '» з усіма записами, фото та коментарями?',
                        ]) ?>
                        <?= Html::endForm() ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<script>
document.querySelectorAll('.copy-link').forEach(function (btn) {
    btn.addEventListener('click', function () {
        navigator.clipboard.writeText(btn.dataset.link).then(function () {
            var i = btn.querySelector('i');
            var prev = i.className;
            i.className = 'fa fa-check';
            setTimeout(function () { i.className = prev; }, 1200);
        });
    });
});
</script>
