<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use yii\bootstrap5\Html;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/images/favicon.png')]);
$this->registerLinkTag(['rel' => 'shortcut icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/images/favicon.png')]);
$this->registerLinkTag(['name' => 'format-detection', 'content' => 'telephone=no']);

?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
    <head>
        <title><?= Html::encode($this->title) ?></title>
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