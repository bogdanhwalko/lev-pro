<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\helpers\FileHelper;

/**
 * @property int $id
 * @property int $project_id
 * @property string|null $body
 * @property int $created_at
 * @property int $updated_at
 *
 * @property WorkProject $project
 * @property WorkProjectComment[] $comments
 */
class WorkProjectPost extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%work_project_post}}';
    }

    public function behaviors(): array
    {
        return [
            TimestampBehavior::class,
        ];
    }

    public function rules(): array
    {
        return [
            ['project_id', 'required'],
            ['project_id', 'integer'],
            ['body', 'string'],
        ];
    }

    public function getProject(): \yii\db\ActiveQuery
    {
        return $this->hasOne(WorkProject::class, ['id' => 'project_id']);
    }

    public function getComments(): \yii\db\ActiveQuery
    {
        return $this->hasMany(WorkProjectComment::class, ['post_id' => 'id'])
            ->orderBy(['created_at' => SORT_ASC, 'id' => SORT_ASC]);
    }

    public function getImagePath(): string
    {
        return Yii::getAlias('@app/../public_html/images/work-projects/' . $this->project_id . '/' . $this->id);
    }

    public function getImageUrl(string $filename): string
    {
        return '/images/work-projects/' . $this->project_id . '/' . $this->id . '/' . $filename;
    }

    public function getImages(): array
    {
        $path = $this->getImagePath();
        if (!is_dir($path)) {
            return [];
        }
        $files = FileHelper::findFiles($path, ['only' => ['*.jpg', '*.jpeg', '*.png', '*.webp']]);
        sort($files);
        return $files;
    }

    public function getImageCount(): int
    {
        return count($this->getImages());
    }

    public function afterDelete()
    {
        parent::afterDelete();

        WorkProjectComment::deleteAll(['post_id' => $this->id]);

        $path = $this->getImagePath();
        if (is_dir($path)) {
            FileHelper::removeDirectory($path);
        }
    }
}
