<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\models\Project;

class GalleryController extends Controller
{
    public function actionIndex(string $id)
    {
        $projects = Project::find()
            ->where(['category' => $id])
            ->orderBy(['sort_order' => SORT_ASC, 'id' => SORT_ASC])
            ->all();

        if (empty($projects)) {
            throw new NotFoundHttpException();
        }

        // Build projects array for the view
        $projectsData = [];
        foreach ($projects as $project) {
            $images = $project->getImages();
            $imageUrls = array_map(
                fn($img) => $project->getImageUrl(basename($img)),
                $images
            );
            $projectsData[] = [
                'id'     => $project->id,
                'name'   => $project->name,
                'images' => $imageUrls,
            ];
        }

        return $this->render('view', [
            'projects' => $projectsData,
            'title'    => strtoupper($id),
        ]);
    }
}
