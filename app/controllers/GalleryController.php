<?php

namespace app\controllers;

use yii\helpers\FileHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Yii;

class GalleryController extends Controller
{
    public function actionIndex(string $id)
    {
        $path = \Yii::getAlias('@app/../public_html/images/users/'. $id);
        if (! is_dir($path)) {
            throw new NotFoundHttpException();
        }

        $images = FileHelper::findFiles($path, ['only' => ['*.jpg', '*.png']]);
        $images = array_map(fn($img) => Yii::getAlias('@images/users/'. strtolower($id) . '/'. basename($img)), $images);

        $projects = [
            [
                'id' => 1,
                'name' => 'Проект 1',
                'images' => array_slice($images, 0, 3),
            ],
            [
                'id' => 2,
                'name' => 'Проект 2',
                'images' => array_slice($images, 3)
            ]
        ];

        return $this->render('view', [
            'images' => $images,
            'projects' => $projects,
            'title' => strtoupper($id)
        ]);
    }
}