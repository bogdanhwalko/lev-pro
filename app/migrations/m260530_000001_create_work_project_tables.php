<?php

use yii\db\Migration;

class m260530_000001_create_work_project_tables extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%work_project}}', [
            'id'               => $this->primaryKey(),
            'title'            => $this->string(255)->notNull(),
            'slug'             => $this->string(190)->notNull(),
            'intro'            => $this->text()->null(),
            'comments_enabled' => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at'       => $this->integer()->notNull(),
            'updated_at'       => $this->integer()->notNull(),
        ]);
        $this->createIndex('idx_work_project_slug', '{{%work_project}}', 'slug', true);

        $this->createTable('{{%work_project_post}}', [
            'id'         => $this->primaryKey(),
            'project_id' => $this->integer()->notNull(),
            'body'       => $this->text()->null(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
        $this->createIndex('idx_work_project_post_project', '{{%work_project_post}}', 'project_id');

        $this->createTable('{{%work_project_comment}}', [
            'id'          => $this->primaryKey(),
            'post_id'     => $this->integer()->notNull(),
            'author_name' => $this->string(120)->notNull(),
            'body'        => $this->text()->notNull(),
            'created_at'  => $this->integer()->notNull(),
        ]);
        $this->createIndex('idx_work_project_comment_post', '{{%work_project_comment}}', 'post_id');
    }

    public function safeDown()
    {
        $this->dropTable('{{%work_project_comment}}');
        $this->dropTable('{{%work_project_post}}');
        $this->dropTable('{{%work_project}}');
    }
}
