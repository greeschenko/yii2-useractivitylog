<?php

use yii\db\Migration;

class m170629_135918_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%useractivitylog}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'ip' => $this->string(),
            'msg' => $this->text(),
            'created_at' => $this->integer(),
            'type' => $this->smallInteger()->notNull()->defaultValue(0),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%useractivitylog}}');
    }
}
