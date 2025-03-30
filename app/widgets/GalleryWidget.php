<?php

namespace app\widgets;

use yii\base\Widget;


class GalleryWidget extends Widget
{
    public function init()
    {
        parent::init();
    }


    public function run()
    {

        return $this->render('gallery');
    }
}