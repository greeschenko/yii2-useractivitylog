<?php

use yii\db\Migration;

/**
 * Class m190302_132943_add_errorlog.
 */
class m190302_132943_add_errorlog extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%usererrorlog}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'ip' => $this->string(),
            'msg' => $this->text(),
            'created_at' => $this->integer(),
            'code' => $this->integer(),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%usererrorlog}}');
    }
}
