<?php

use yii\db\Migration;

class m260404_000001_create_project_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%project}}', [
            'id'          => $this->primaryKey(),
            'name'        => $this->string(255)->notNull(),
            'category'    => $this->string(100)->notNull(),
            'description' => $this->text()->null(),
            'sort_order'  => $this->integer()->notNull()->defaultValue(0),
            'created_at'  => $this->integer()->notNull(),
            'updated_at'  => $this->integer()->notNull(),
        ]);

        $this->createIndex('idx_project_category', '{{%project}}', 'category');
    }

    public function safeDown()
    {
        $this->dropTable('{{%project}}');
    }
}
