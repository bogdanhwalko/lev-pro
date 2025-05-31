<?php

$this->title = str_replace('-', ' ', $title);

$this->registerCssFile('@web/css/gallery.css');

?>
<div class="container bg-white" id="projects">
    <div class="row">
        <div class="col-lg-12 section-head text-center" style="padding-top: 40px;">
            <h5 class="title-small">GALLERY &amp; EXAMPLE</h5>
            <div class="dlab-separator-outer">
                <div class="dlab-separator bg-primary style-skew"></div>
            </div>
            <h2  class="font-weight-700 m-b0"><?= $title; ?></h2>
        </div>
    </div>
    <div class="row spno">
        <?= \dosamigos\gallery\Gallery::widget([
            'items' => array_map(fn($img) => ['src' => Yii::getAlias('@web/images/users/'. strtolower($title) . '/'. basename($img))], $images),
            'options' => ['class' => 'gallery']
        ]);?>

    </div>
</div>
