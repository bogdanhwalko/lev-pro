<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\helpers\FileHelper;

class Project extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%project}}';
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
            [['name', 'category'], 'required'],
            [['name', 'category'], 'string', 'max' => 255],
            ['description', 'string'],
            ['sort_order', 'integer', 'min' => 0],
            ['sort_order', 'default', 'value' => 0],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id'          => 'ID',
            'name'        => 'Назва проекту',
            'category'    => 'Категорія',
            'description' => 'Опис',
            'sort_order'  => 'Порядок сортування',
            'created_at'  => 'Створено',
            'updated_at'  => 'Оновлено',
        ];
    }

    public function getImagePath(): string
    {
        return Yii::getAlias('@app/../public_html/images/projects/' . $this->id);
    }

    public function getImageUrl(string $filename): string
    {
        return '/images/projects/' . $this->id . '/' . $filename;
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

    public function getCoverImage(): ?string
    {
        $images = $this->getImages();
        if (empty($images)) {
            return null;
        }
        return $this->getImageUrl(basename($images[0]));
    }

    public function afterDelete()
    {
        parent::afterDelete();
        $path = $this->getImagePath();
        if (is_dir($path)) {
            FileHelper::removeDirectory($path);
        }
    }
}
