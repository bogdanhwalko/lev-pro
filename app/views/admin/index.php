<?php
/** @var yii\web\View $this */
/** @var array $groups category => ['items' => app\models\Project[], 'pagination' => yii\data\Pagination] */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = 'Галерея';

$hasProjects = false;
foreach ($groups as $group) {
    if (!empty($group['items'])) {
        $hasProjects = true;
        break;
    }
}
?>

<div class="d-flex justify-content-between align-items-center mb-3 gap-2">
    <h5 class="mb-0 fw-bold">Список галерей</h5>
    <?= Html::a(
        '<i class="fa fa-plus"></i> Нова галерея',
        ['/admin/create'],
        ['class' => 'btn btn-primary btn-sm', 'encode' => false]
    ) ?>
</div>

<?php if (!$hasProjects): ?>
    <div class="card">
        <div class="card-body text-center py-5 text-muted">
            <i class="fa fa-folder-open fa-3x d-block mb-3 text-secondary"></i>
            <p class="mb-2">Галерей ще немає.</p>
            <?= Html::a('Створіть першу галерею', ['/admin/create'], ['class' => 'btn btn-primary']) ?>
        </div>
    </div>

<?php else: ?>
    <?php foreach ($groups as $category => $group): ?>
        <?php
        $items = $group['items'];
        $pagination = $group['pagination'];
        if (empty($items)) {
            continue;
        }
        ?>
        <p class="text-uppercase text-muted fw-bold mb-2 mt-4" style="font-size:.75rem;letter-spacing:.06em">
            <i class="fa fa-tag"></i> <?= Html::encode($category) ?>
            <span class="text-muted fw-normal">(<?= $pagination->totalCount ?>)</span>
        </p>

        <!-- Desktop table -->
        <div class="card mb-3 project-table-wrap">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light" style="font-size:.82rem">
                        <tr>
                            <th style="width:72px"></th>
                            <th>Назва галереї</th>
                            <th style="width:80px" class="text-center">Фото</th>
                            <th style="width:80px" class="text-center">Порядок</th>
                            <th style="width:150px"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $project): ?>
                            <tr>
                                <td>
                                    <?php $cover = $project->getCoverImage(); ?>
                                    <?php if ($cover): ?>
                                        <img src="<?= Html::encode($cover) ?>" alt=""
                                             style="width:56px;height:42px;object-fit:cover;border-radius:6px;display:block">
                                    <?php else: ?>
                                        <div style="width:56px;height:42px;background:#e9ecef;border-radius:6px;display:flex;align-items:center;justify-content:center">
                                            <i class="fa fa-picture-o text-muted"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <strong><?= Html::encode($project->name) ?></strong>
                                    <?php if ($project->description): ?>
                                        <div class="text-muted text-truncate" style="font-size:.8rem;max-width:260px">
                                            <?= Html::encode($project->description) ?>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-secondary rounded-pill"><?= $project->getImageCount() ?></span>
                                </td>
                                <td class="text-center text-muted" style="font-size:.85rem"><?= $project->sort_order ?></td>
                                <td>
                                    <div class="d-flex gap-1 justify-content-end">
                                        <?= Html::a('<i class="fa fa-picture-o"></i>', ['/admin/photos', 'id' => $project->id], [
                                            'class' => 'btn btn-sm btn-outline-primary', 'title' => 'Фото', 'encode' => false,
                                        ]) ?>
                                        <?= Html::a('<i class="fa fa-pencil"></i>', ['/admin/update', 'id' => $project->id], [
                                            'class' => 'btn btn-sm btn-outline-secondary', 'title' => 'Редагувати', 'encode' => false,
                                        ]) ?>
                                        <?= Html::beginForm(['/admin/delete', 'id' => $project->id], 'post', ['style' => 'display:inline']) ?>
                                        <?= Html::submitButton('<i class="fa fa-trash"></i>', [
                                            'class' => 'btn btn-sm btn-outline-danger', 'title' => 'Видалити', 'encode' => false,
                                            'data-confirm' => 'Видалити галерею «' . Html::encode($project->name) . '» та всі її фото?',
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
        <div class="project-card-mobile mb-3">
            <?php foreach ($items as $project): ?>
                <?php $cover = $project->getCoverImage(); ?>
                <div class="card mb-2">
                    <div class="card-body p-3">
                        <div class="d-flex gap-3 align-items-center">
                            <?php if ($cover): ?>
                                <img src="<?= Html::encode($cover) ?>" alt=""
                                     style="width:72px;height:54px;object-fit:cover;border-radius:6px;flex-shrink:0">
                            <?php else: ?>
                                <div style="width:72px;height:54px;background:#e9ecef;border-radius:6px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                                    <i class="fa fa-picture-o text-muted"></i>
                                </div>
                            <?php endif; ?>
                            <div class="flex-grow-1 min-w-0">
                                <div class="fw-semibold text-truncate"><?= Html::encode($project->name) ?></div>
                                <div class="text-muted" style="font-size:.78rem">
                                    <i class="fa fa-photo"></i> <?= $project->getImageCount() ?> фото
                                    &nbsp;·&nbsp; порядок: <?= $project->sort_order ?>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex gap-2 mt-2">
                            <?= Html::a(
                                '<i class="fa fa-picture-o"></i> Фото',
                                ['/admin/photos', 'id' => $project->id],
                                ['class' => 'btn btn-sm btn-outline-primary flex-fill text-center', 'encode' => false]
                            ) ?>
                            <?= Html::a(
                                '<i class="fa fa-pencil"></i> Редагувати',
                                ['/admin/update', 'id' => $project->id],
                                ['class' => 'btn btn-sm btn-outline-secondary flex-fill text-center', 'encode' => false]
                            ) ?>
                            <?= Html::beginForm(['/admin/delete', 'id' => $project->id], 'post', ['style' => 'flex:1']) ?>
                            <?= Html::submitButton('<i class="fa fa-trash"></i> Видалити', [
                                'class' => 'btn btn-sm btn-outline-danger w-100', 'encode' => false,
                                'data-confirm' => 'Видалити галерею «' . Html::encode($project->name) . '»?',
                            ]) ?>
                            <?= Html::endForm() ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if ($pagination->pageCount > 1): ?>
            <nav class="d-flex justify-content-center mb-3">
                <?= LinkPager::widget([
                    'pagination'       => $pagination,
                    'options'          => ['class' => 'pagination pagination-sm mb-0'],
                    'linkContainerOptions' => ['class' => 'page-item'],
                    'linkOptions'      => ['class' => 'page-link'],
                    'disabledListItemSubTagOptions' => ['tag' => 'a', 'class' => 'page-link'],
                ]) ?>
            </nav>
        <?php endif; ?>

    <?php endforeach; ?>
<?php endif; ?>
