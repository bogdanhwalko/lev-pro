<?php

namespace app\controllers;

use yii\helpers\FileHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class GalleryController extends Controller
{
    public function actionIndex(string $id)
    {
        $path = \Yii::getAlias('@app/../public_html/images/users/'. $id);
        if (! is_dir($path)) {
            throw new NotFoundHttpException();
        }

        return $this->render('view', [
            'images' => FileHelper::findFiles($path, ['only' => ['*.jpg', '*.png']]),
            'title' => strtoupper($id)
        ]);
    }
}