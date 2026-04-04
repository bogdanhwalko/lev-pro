<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\FileHelper;
use app\models\Project;

class AdminController extends Controller
{
    public $layout = 'admin';

    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete'       => ['post'],
                    'delete-photo' => ['post'],
                    'upload'       => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex(): string
    {
        $projects = Project::find()
            ->orderBy(['category' => SORT_ASC, 'sort_order' => SORT_ASC, 'id' => SORT_ASC])
            ->all();

        return $this->render('index', ['projects' => $projects]);
    }

    public function actionCreate(): Response|string
    {
        $model = new Project();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Проект створено. Тепер завантажте фото.');
            return $this->redirect(['photos', 'id' => $model->id]);
        }

        return $this->render('form', ['model' => $model]);
    }

    public function actionUpdate(int $id): Response|string
    {
        $model = $this->findProject($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Проект оновлено.');
            return $this->redirect(['index']);
        }

        return $this->render('form', ['model' => $model]);
    }

    public function actionDelete(int $id): Response
    {
        $model = $this->findProject($id);
        $model->delete();
        Yii::$app->session->setFlash('success', 'Проект видалено.');
        return $this->redirect(['index']);
    }

    public function actionPhotos(int $id): string
    {
        $model = $this->findProject($id);
        return $this->render('photos', ['model' => $model]);
    }

    public function actionUpload(int $id): Response
    {
        $model = $this->findProject($id);

        $files = UploadedFile::getInstancesByName('photos');
        if (empty($files)) {
            Yii::$app->session->setFlash('error', 'Файли не вибрані.');
            return $this->redirect(['photos', 'id' => $id]);
        }

        $path = $model->getImagePath();
        FileHelper::createDirectory($path);

        $uploaded = 0;
        foreach ($files as $file) {
            if ($file->error !== UPLOAD_ERR_OK) {
                continue;
            }
            $ext = strtolower($file->extension);
            if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
                continue;
            }
            $name = uniqid('img_', true) . '.' . $ext;
            if ($file->saveAs($path . '/' . $name)) {
                $uploaded++;
            }
        }

        Yii::$app->session->setFlash('success', "Завантажено $uploaded фото.");
        return $this->redirect(['photos', 'id' => $id]);
    }

    public function actionDeletePhoto(int $id): Response
    {
        $model = $this->findProject($id);
        $file = Yii::$app->request->post('file', '');

        // Prevent path traversal — only allow plain filename
        $filename = basename($file);
        $fullPath = $model->getImagePath() . '/' . $filename;

        if ($filename && is_file($fullPath)) {
            unlink($fullPath);
            Yii::$app->session->setFlash('success', 'Фото видалено.');
        }

        return $this->redirect(['photos', 'id' => $id]);
    }

    private function findProject(int $id): Project
    {
        $model = Project::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException('Проект не знайдено.');
        }
        return $model;
    }
}
