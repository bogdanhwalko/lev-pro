<?php
/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\assets;

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
        'https://fonts.googleapis.com/css?family=Montserrat:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i|Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i|Playfair+Display:400,400i,700,700i,900,900i|Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i|Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i|Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i&display=swap',
        'plugins/revolution/revolution/css/revolution.min.css'
    ];

    public $js = [
        'js/jquery.min.js',
        'plugins/wow/wow.js',
        'plugins/bootstrap/js/popper.min.js',
        'plugins/bootstrap/js/bootstrap.min.js',
        'plugins/bootstrap-select/bootstrap-select.min.js',
        'plugins/bootstrap-touchspin/jquery.bootstrap-touchspin.js',
        'plugins/magnific-popup/magnific-popup.js',
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
        FirstJsAsset::class
    ];
}
