<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * @property int $id
 * @property int $post_id
 * @property string $author_name
 * @property string $body
 * @property int $created_at
 *
 * @property WorkProjectPost $post
 */
class WorkProjectComment extends ActiveRecord
{
    /** honeypot, not persisted */
    public ?string $website = null;

    public static function tableName(): string
    {
        return '{{%work_project_comment}}';
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'updatedAtAttribute' => false,
            ],
        ];
    }

    public function rules(): array
    {
        return [
            [['post_id', 'author_name', 'body'], 'required'],
            ['post_id', 'integer'],
            ['author_name', 'string', 'max' => 120],
            ['body', 'string', 'min' => 2, 'max' => 2000],
            // honeypot: accepted by validation, handled silently in the controller
            ['website', 'safe'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'author_name' => 'Name',
            'body'        => 'Comment',
        ];
    }

    public function getPost(): \yii\db\ActiveQuery
    {
        return $this->hasOne(WorkProjectPost::class, ['id' => 'post_id']);
    }
}
