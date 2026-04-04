<?php

/** @var yii\web\View $this */
/** @var string $content */ 

use app\assets\AppAsset;
use yii\bootstrap5\Html;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1']);
$this->registerMetaTag(['name' => 'robots', 'content' => 'index, follow']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords',    'content' => $this->params['meta_keywords']    ?? '']);

// Open Graph
$this->registerMetaTag(['property' => 'og:type',        'content' => 'website']);
$this->registerMetaTag(['property' => 'og:site_name',   'content' => 'LevPro Construction']);
$this->registerMetaTag(['property' => 'og:title',       'content' => $this->params['og_title']       ?? $this->title]);
$this->registerMetaTag(['property' => 'og:description', 'content' => $this->params['og_description'] ?? ($this->params['meta_description'] ?? '')]);
$this->registerMetaTag(['property' => 'og:image',       'content' => $this->params['og_image']       ?? Yii::getAlias('@web/images/og-default.jpg')]);
$this->registerMetaTag(['property' => 'og:url',         'content' => Yii::$app->request->absoluteUrl]);

$this->registerLinkTag(['rel' => 'icon',         'type' => 'image/png', 'href' => Yii::getAlias('@web/images/favicon.png')]);
$this->registerLinkTag(['rel' => 'shortcut icon','type' => 'image/png', 'href' => Yii::getAlias('@web/images/favicon.png')]);
$this->registerLinkTag(['name' => 'format-detection', 'content' => 'telephone=no']);

?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
    <head>
        <title><?= Html::encode($this->title . ' | LevPro Construction') ?></title>
        <?php $this->head() ?>
    </head>
    <body id="bg">
        <?php $this->beginBody() ?>

        <div class="page-wraper">
            <div id="loading-area" class="construct-loading"></div>
            <?= $this->render('header') ?>

            <?= $content ?>

            <?= $this->render('footer') ?>
        </div>

        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>