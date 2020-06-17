<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%organizations}}`.
 */
class m200617_073939_create_organizations_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%organizations}}', [
            'id' => $this->primaryKey(),
            'full_name'=>$this->text(),
            'name'=>$this->text(),
            'short_name'=>$this->text(),
            'id_region'=>$this->integer(),
            'id_founder'=>$this->integer(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
            'system_status'=>$this->integer()->defaultValue(1),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%organizations}}');
    }
}
