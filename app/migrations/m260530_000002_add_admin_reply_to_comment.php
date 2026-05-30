<?php

use yii\db\Migration;

class m260530_000002_add_admin_reply_to_comment extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%work_project_comment}}', 'admin_reply', $this->text()->null());
        $this->addColumn('{{%work_project_comment}}', 'admin_reply_at', $this->integer()->null());
    }

    public function safeDown()
    {
        $this->dropColumn('{{%work_project_comment}}', 'admin_reply_at');
        $this->dropColumn('{{%work_project_comment}}', 'admin_reply');
    }
}
