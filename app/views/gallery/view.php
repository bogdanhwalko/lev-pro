<?php

$this->title = str_replace('-', ' ', $title);

use yii\helpers\Html;
use newerton\fancybox3\FancyBox;

$this->registerCss("
.project-gallery-block {
    margin-bottom: 30px;
}

.gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 12px;
}

.gallery-item {
    aspect-ratio: 4 / 3;
    overflow: hidden;
    background: #f1f1f1;
    border-radius: 6px;
}

.gallery-item a {
    display: block;
    width: 100%;
    height: 100%;
}

.gallery-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

");

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
        <?= FancyBox::widget([
            'target' => '[data-fancybox="gallery"]',
            'config' => [
                'loop' => true,
                'arrows' => true,
                'infobar' => true,
                'toolbar' => true,
                'gutter' => true,
                'buttons' => [
                    'slideShow',
                    'fullScreen',
                    'thumbs',
                    'close',
                ],
                'animationEffect' => 'zoom',
                'transitionEffect' => 'fade',
            ],
        ])
        ?>

        <?php foreach ($projects as $project): ?>
            <div class="project-gallery-block">
                <h3><?= Html::encode($project['name']) ?></h3>

                <div class="gallery-grid">
                    <?php foreach ($project['images'] as $image): ?>
                        <div class="gallery-item">
                            <?= Html::a(
                                Html::img($image, [
                                    'class' => 'gallery-img',
                                    'alt' => $project['name'],
                                ]),
                                $image,
                                [
                                    'data-fancybox' => 'project-' . $project['id'],
                                    'data-caption' => $project['name'],
                                ]
                            ) ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>

    </div>
    <div style="margin-top: 100px;"></div>
</div>
