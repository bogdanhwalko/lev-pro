<?php

namespace app\assets;

use Yii;
use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'css/fonts.css',
        'plugins/bootstrap/css/bootstrap.min.css',
        'plugins/fontawesome/css/font-awesome.min.css',
        'plugins/line-awesome/css/line-awesome.min.css',
        'plugins/flaticon/flaticon.css',
        'plugins/themify/themify-icons.css',
        'plugins/owl-carousel/owl.carousel.css',
        'plugins/bootstrap-select/bootstrap-select.min.css',
        'plugins/magnific-popup/magnific-popup.css',
        'plugins/animate/animate.css',
        'plugins/button-effects/button.css',
        'css/style.css',
        'css/skin/skin-1.css',
        'css/temp.css',
    ];

    public $js = [
        'plugins/wow/wow.js',
        'plugins/bootstrap/js/popper.min.js',
        'plugins/bootstrap/js/bootstrap.min.js',
        'plugins/bootstrap-select/bootstrap-select.min.js',
        'plugins/magnific-popup/magnific-popup.js',
        'js/jquery-load-shim.js',
        'plugins/counter/waypoints-min.js',
        'plugins/counter/counterup.min.js',
        'plugins/imagesloaded/imagesloaded.js',
        'plugins/masonry/masonry-3.1.4.js',
        'plugins/masonry/masonry.filter.js',
        'plugins/owl-carousel/owl.carousel.js',
        'js/custom.js',
        'js/dz.carousel.js',
        'js/dz.ajax.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        FirstJsAsset::class,
    ];

    public function init(): void
    {
        parent::init();
        $v = Yii::$app->params['assetVersion'] ?? '1';
        $this->css = array_map(
            static fn($f) => is_string($f) && !str_starts_with($f, 'http') ? "$f?v=$v" : $f,
            $this->css
        );
        $this->js = array_map(
            static fn($f) => is_string($f) ? "$f?v=$v" : $f,
            $this->js
        );
    }
}
