<?php

namespace app\assets;

use yii\web\AssetBundle;

class FirstJsAsset extends AssetBundle
{
    public $basePath = '@webroot';

    public $baseUrl = '@web';

    public $jsOptions = [
        'position' => \yii\web\View::POS_HEAD,
    ];

    public $js = [];
}