<?php
/** @var yii\web\View $this */
/** @var app\models\WorkProject $model */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$isNew = $model->isNewRecord;
$this->title = $isNew ? 'Новий проект' : 'Редагувати проект';
?>

<div class="d-flex align-items-center mb-3 gap-2">
    <?= Html::a(
        '<i class="fa fa-arrow-left"></i>',
        ['/project/index'],
        ['class' => 'btn btn-outline-secondary', 'title' => 'Назад', 'encode' => false]
    ) ?>
    <h5 class="mb-0 fw-bold"><?= Html::encode($this->title) ?></h5>
</div>

<div class="card" style="max-width:640px">
    <div class="card-body p-3 p-md-4">
        <?php $form = ActiveForm::begin([
            'options' => ['novalidate' => true],
            'fieldConfig' => ['options' => ['class' => 'mb-3']],
        ]); ?>

        <?= $form->field($model, 'title')->textInput([
            'class' => 'form-control form-control-lg',
            'autofocus' => true,
        ])->label('Назва проекту <span class="text-danger">*</span>', ['encode' => false]) ?>

        <?= $form->field($model, 'intro')->textarea([
            'rows' => 3,
            'class' => 'form-control',
            'placeholder' => 'Короткий опис проекту (показується вгорі сторінки, необов\'язково)',
        ]) ?>

        <?= $form->field($model, 'comments_enabled')->checkbox() ?>

        <div class="d-flex flex-wrap gap-2 mt-3">
            <?= Html::submitButton(
                ($isNew
                    ? '<i class="fa fa-check"></i> Створити проект'
                    : '<i class="fa fa-check"></i> Зберегти'),
                ['class' => 'btn btn-primary', 'encode' => false]
            ) ?>
            <?= Html::a('Скасувати', ['/project/index'], ['class' => 'btn btn-outline-secondary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
