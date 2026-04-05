<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use app\models\Project;

class GalleryController extends Controller
{
    private const PER_PAGE = 5;

    public function actionIndex(string $id)
    {
        $total = (int) Project::find()->where(['category' => $id])->count();

        $projects = Project::find()
            ->where(['category' => $id])
            ->orderBy(['sort_order' => SORT_ASC, 'id' => SORT_ASC])
            ->limit(self::PER_PAGE)
            ->all();

        return $this->render('view', [
            'projects' => $this->buildProjectsData($projects),
            'title'    => strtoupper($id),
            'category' => $id,
            'total'    => $total,
            'loaded'   => min(self::PER_PAGE, $total),
        ]);
    }

    public function actionMore(string $id, int $offset = 0): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $projects = Project::find()
            ->where(['category' => $id])
            ->orderBy(['sort_order' => SORT_ASC, 'id' => SORT_ASC])
            ->offset($offset)
            ->limit(self::PER_PAGE)
            ->all();

        return $this->buildProjectsData($projects);
    }

    private function buildProjectsData(array $projects): array
    {
        $data = [];
        foreach ($projects as $project) {
            $images = $project->getImages();
            $data[] = [
                'id'     => $project->id,
                'name'   => $project->name,
                'images' => array_map(
                    fn($img) => $project->getImageUrl(basename($img)),
                    $images
                ),
            ];
        }
        return $data;
    }
}
