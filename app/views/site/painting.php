<?php

$this->registerCssFile('@web/css/gallery.css');

?>
<div class="container bg-white" id="projects">
    <div class="row">
        <div class="col-lg-12 section-head text-center" style="padding-top: 40px;">
            <h5 class="title-small">GALLERY &amp; EXAMPLE</h5>
            <div class="dlab-separator-outer">
                <div class="dlab-separator bg-primary style-skew"></div>
            </div>
            <h2  class="font-weight-700 m-b0">PAINTING</h2>
        </div>
    </div>
    <div class="row spno">
        <?= \dosamigos\gallery\Gallery::widget([
            'items' => [
                ['src' => Yii::getAlias('@web/images/users/painting/1.jpg')],
                ['src' => Yii::getAlias('@web/images/users/painting/2.jpg')],
                ['src' => Yii::getAlias('@web/images/users/painting/3.jpg')],
                ['src' => Yii::getAlias('@web/images/users/painting/4.jpg')],
                ['src' => Yii::getAlias('@web/images/users/painting/5.jpg')],
                ['src' => Yii::getAlias('@web/images/users/painting/6.jpg')],
                ['src' => Yii::getAlias('@web/images/users/painting/7.jpg')]
            ],
            'options' => ['class' => 'gallery']
        ]);?>

    </div>
</div>
