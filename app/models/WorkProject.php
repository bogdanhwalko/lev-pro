<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\helpers\FileHelper;
use yii\helpers\Inflector;
use yii\helpers\Url;

/**
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string|null $intro
 * @property int $comments_enabled
 * @property int $created_at
 * @property int $updated_at
 *
 * @property WorkProjectPost[] $posts
 */
class WorkProject extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%work_project}}';
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
            [['title'], 'required'],
            [['title'], 'string', 'max' => 255],
            ['intro', 'string'],
            ['comments_enabled', 'boolean'],
            ['comments_enabled', 'default', 'value' => 1],
            ['slug', 'string', 'max' => 190],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id'               => 'ID',
            'title'            => 'Назва проекту',
            'intro'            => 'Опис',
            'comments_enabled' => 'Дозволити коментарі',
            'created_at'       => 'Створено',
            'updated_at'       => 'Оновлено',
        ];
    }

    public function beforeSave($insert): bool
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        if (empty($this->slug)) {
            $this->slug = $this->generateUniqueSlug();
        }
        return true;
    }

    private function generateUniqueSlug(): string
    {
        $base = Inflector::slug((string) $this->title);
        if ($base === '') {
            $base = 'project';
        }
        do {
            $slug = $base . '-' . substr(bin2hex(random_bytes(5)), 0, 8);
        } while (static::find()->where(['slug' => $slug])->exists());

        return $slug;
    }

    public function getPosts(): \yii\db\ActiveQuery
    {
        return $this->hasMany(WorkProjectPost::class, ['project_id' => 'id'])
            ->orderBy(['created_at' => SORT_ASC, 'id' => SORT_ASC]);
    }

    public function getPostCount(): int
    {
        return (int) WorkProjectPost::find()->where(['project_id' => $this->id])->count();
    }

    public function getCommentCount(): int
    {
        return (int) WorkProjectComment::find()
            ->leftJoin('{{%work_project_post}} p', 'p.id = {{%work_project_comment}}.post_id')
            ->where(['p.project_id' => $this->id])
            ->count();
    }

    public function getUrl(bool $absolute = true): string
    {
        return Url::to(['/site/project', 'slug' => $this->slug], $absolute);
    }

    public function getImageDir(): string
    {
        return Yii::getAlias('@app/../public_html/images/work-projects/' . $this->id);
    }

    public function getCoverDir(): string
    {
        return $this->getImageDir() . '/cover';
    }

    /** URL of the cover image, or null if none uploaded. */
    public function getCoverImage(): ?string
    {
        $dir = $this->getCoverDir();
        if (!is_dir($dir)) {
            return null;
        }
        $files = FileHelper::findFiles($dir, ['only' => ['*.jpg', '*.jpeg', '*.png', '*.webp']]);
        if (empty($files)) {
            return null;
        }
        sort($files);
        return '/images/work-projects/' . $this->id . '/cover/' . basename($files[0]);
    }

    public function afterDelete()
    {
        parent::afterDelete();

        // cascade delete posts (each cleans its own files + comments)
        foreach (WorkProjectPost::find()->where(['project_id' => $this->id])->all() as $post) {
            $post->delete();
        }

        $dir = $this->getImageDir();
        if (is_dir($dir)) {
            FileHelper::removeDirectory($dir);
        }
    }
}
