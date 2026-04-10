<?php
/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\assets;

use Yii;
use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
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


        //'css/montserrat.css',
        'https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700&family=Open+Sans:wght@400;600;700&family=Poppins:wght@300;400;500;600;700&display=swap',
        'plugins/revolution/revolution/css/revolution.min.css'
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
        'plugins/revolution/revolution/js/jquery.themepunch.tools.min.js',
        'plugins/revolution/revolution/js/jquery.themepunch.revolution.min.js',
        'plugins/revolution/revolution/js/extensions/revolution.extension.actions.min.js',
        'plugins/revolution/revolution/js/extensions/revolution.extension.carousel.min.js',
        'plugins/revolution/revolution/js/extensions/revolution.extension.kenburn.min.js',
        'plugins/revolution/revolution/js/extensions/revolution.extension.layeranimation.min.js',
        'plugins/revolution/revolution/js/extensions/revolution.extension.navigation.min.js',
        'plugins/revolution/revolution/js/extensions/revolution.extension.parallax.min.js',
        'plugins/revolution/revolution/js/extensions/revolution.extension.slideanims.min.js',
        'plugins/revolution/revolution/js/extensions/revolution.extension.video.min.js',
        'js/rev.slider.js',
        'js/ready-script.js',
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
