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
use app\models\WorkProject;
use app\models\WorkProjectPost;
use app\models\WorkProjectComment;

class ProjectController extends Controller
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
                    'delete'         => ['post'],
                    'post-create'    => ['post'],
                    'post-delete'    => ['post'],
                    'photo-delete'   => ['post'],
                    'comment-delete' => ['post'],
                    'comment-reply'  => ['post'],
                    'cover'          => ['post'],
                    'cover-delete'   => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex(): string
    {
        $projects = WorkProject::find()
            ->orderBy(['created_at' => SORT_DESC, 'id' => SORT_DESC])
            ->all();

        return $this->render('index', ['projects' => $projects]);
    }

    public function actionCreate(): Response|string
    {
        $model = new WorkProject();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Проект створено. Тепер додайте записи.');
            return $this->redirect(['manage', 'id' => $model->id]);
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
        $this->findProject($id)->delete();
        Yii::$app->session->setFlash('success', 'Проект видалено.');
        return $this->redirect(['index']);
    }

    public function actionManage(int $id): string
    {
        $model = $this->findProject($id);
        return $this->render('manage', [
            'model' => $model,
            'posts' => $model->getPosts()->with('comments')->all(),
        ]);
    }

    public function actionPostCreate(int $id): Response
    {
        $project = $this->findProject($id);

        $post = new WorkProjectPost();
        $post->project_id = $project->id;
        $post->body = trim((string) Yii::$app->request->post('body', '')) ?: null;

        $files = UploadedFile::getInstancesByName('photos');

        if (empty($post->body) && empty($files)) {
            Yii::$app->session->setFlash('error', 'Додайте текст або хоча б одне фото.');
            return $this->redirect(['manage', 'id' => $project->id]);
        }

        if (!$post->save()) {
            Yii::$app->session->setFlash('error', 'Не вдалося створити запис.');
            return $this->redirect(['manage', 'id' => $project->id]);
        }

        $uploaded = $this->savePhotos($post, $files);

        Yii::$app->session->setFlash('success', "Запис додано" . ($uploaded ? " ($uploaded фото)." : "."));
        return $this->redirect(['manage', 'id' => $project->id]);
    }

    public function actionPostDelete(int $id): Response
    {
        $post = $this->findPost($id);
        $projectId = $post->project_id;
        $post->delete();
        Yii::$app->session->setFlash('success', 'Запис видалено.');
        return $this->redirect(['manage', 'id' => $projectId]);
    }

    public function actionPhotoDelete(int $id): Response
    {
        $post = $this->findPost($id);
        $filename = basename((string) Yii::$app->request->post('file', ''));
        $fullPath = $post->getImagePath() . '/' . $filename;

        if ($filename && is_file($fullPath)) {
            unlink($fullPath);
            Yii::$app->session->setFlash('success', 'Фото видалено.');
        }

        return $this->redirect(['manage', 'id' => $post->project_id]);
    }

    public function actionCover(int $id): Response
    {
        $project = $this->findProject($id);

        $file = UploadedFile::getInstanceByName('cover');
        if (!$file || $file->error !== UPLOAD_ERR_OK) {
            Yii::$app->session->setFlash('error', 'Файл не вибрано.');
            return $this->redirect(['manage', 'id' => $project->id]);
        }
        $ext = strtolower($file->extension);
        if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
            Yii::$app->session->setFlash('error', 'Недопустимий формат файлу.');
            return $this->redirect(['manage', 'id' => $project->id]);
        }

        $dir = $project->getCoverDir();
        if (is_dir($dir)) {
            FileHelper::removeDirectory($dir);
        }
        FileHelper::createDirectory($dir);

        if ($file->saveAs($dir . '/cover_' . uniqid() . '.' . $ext)) {
            Yii::$app->session->setFlash('success', 'Обкладинку оновлено.');
        } else {
            Yii::$app->session->setFlash('error', 'Не вдалося зберегти обкладинку.');
        }

        return $this->redirect(['manage', 'id' => $project->id]);
    }

    public function actionCoverDelete(int $id): Response
    {
        $project = $this->findProject($id);
        $dir = $project->getCoverDir();
        if (is_dir($dir)) {
            FileHelper::removeDirectory($dir);
            Yii::$app->session->setFlash('success', 'Обкладинку видалено.');
        }
        return $this->redirect(['manage', 'id' => $project->id]);
    }

    public function actionCommentReply(int $id): Response
    {
        $comment = WorkProjectComment::findOne($id);
        if (!$comment) {
            throw new NotFoundHttpException('Коментар не знайдено.');
        }
        $reply = trim((string) Yii::$app->request->post('reply', ''));
        if ($reply === '') {
            $comment->admin_reply = null;
            $comment->admin_reply_at = null;
            Yii::$app->session->setFlash('success', 'Відповідь видалено.');
        } else {
            $comment->admin_reply = $reply;
            $comment->admin_reply_at = time();
            Yii::$app->session->setFlash('success', 'Відповідь збережено.');
        }
        $comment->save(false);

        $post = WorkProjectPost::findOne($comment->post_id);
        return $this->redirect(['manage', 'id' => $post?->project_id]);
    }

    public function actionCommentDelete(int $id): Response
    {
        $comment = WorkProjectComment::findOne($id);
        if (!$comment) {
            throw new NotFoundHttpException('Коментар не знайдено.');
        }
        $post = WorkProjectPost::findOne($comment->post_id);
        $comment->delete();
        Yii::$app->session->setFlash('success', 'Коментар видалено.');
        return $this->redirect(['manage', 'id' => $post?->project_id]);
    }

    private function savePhotos(WorkProjectPost $post, array $files): int
    {
        if (empty($files)) {
            return 0;
        }
        $path = $post->getImagePath();
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
        return $uploaded;
    }

    private function findProject(int $id): WorkProject
    {
        $model = WorkProject::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException('Проект не знайдено.');
        }
        return $model;
    }

    private function findPost(int $id): WorkProjectPost
    {
        $model = WorkProjectPost::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException('Запис не знайдено.');
        }
        return $model;
    }
}
