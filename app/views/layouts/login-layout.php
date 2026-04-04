<?php
/** @var yii\web\View $this */
/** @var string $content */

use yii\bootstrap5\BootstrapAsset;
use yii\bootstrap5\BootstrapPluginAsset;
use yii\helpers\Html;

BootstrapAsset::register($this);
BootstrapPluginAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/png', 'href' => Yii::getAlias('@web/images/favicon.png')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title><?= Html::encode($this->title ?? '') ?></title>
    <?php $this->head() ?>
</head>
<body style="margin:0;background:#f4f6f9;min-height:100vh;display:flex;align-items:center;justify-content:center">
<?php $this->beginBody() ?>
<?= $content ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
