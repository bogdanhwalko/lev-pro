<?php
/** @var yii\web\View $this */
/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

$this->title = 'Вхід';

$this->registerCssFile('/plugins/fontawesome/css/font-awesome.min.css');
?>

<div style="width:100%;max-width:380px;padding:20px">
    <div class="card shadow-sm">
        <div class="card-body p-4">
                <div class="text-center mb-4">
                    <i class="fa fa-shield fa-3x text-primary"></i>
                    <h4 class="mt-3 mb-0 fw-bold">Адмін-панель</h4>
                    <p class="text-muted small mt-1">LevPro Construction</p>
                </div>

                <?php $form = ActiveForm::begin(['id' => 'login-form', 'options' => ['novalidate' => true]]); ?>

                <?= $form->field($model, 'username', ['options' => ['class' => 'mb-3']])->textInput([
                    'autofocus' => true,
                    'placeholder' => 'Логін',
                    'class' => 'form-control form-control-lg',
                    'autocomplete' => 'username',
                ])->label(false) ?>

                <?= $form->field($model, 'password', ['options' => ['class' => 'mb-3']])->passwordInput([
                    'placeholder' => 'Пароль',
                    'class' => 'form-control form-control-lg',
                    'autocomplete' => 'current-password',
                ])->label(false) ?>

                <?= $form->field($model, 'rememberMe', ['options' => ['class' => 'mb-4']])
                    ->checkbox(['label' => 'Запам\'ятати мене']) ?>

                <?= Html::submitButton(
                    '<i class="fa fa-sign-in"></i> Увійти',
                    ['class' => 'btn btn-primary w-100 btn-lg', 'name' => 'login-button', 'encode' => false]
                ) ?>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
