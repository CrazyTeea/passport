<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%founders}}`.
 */
class m200617_074459_create_founders_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%founders}}', [
            'id' => $this->primaryKey(),
            'founder'=>$this->text()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%founders}}');
    }
}
