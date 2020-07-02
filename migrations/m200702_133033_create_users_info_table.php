<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users_info}}`.
 */
class m200702_133033_create_users_info_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users_info}}', [
            'id' => $this->primaryKey(),
            'id_org'=>$this->integer(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
            'name'=>$this->text(),
            'position'=>$this->text(),
            'phone'=>$this->text(),
            'email'=>$this->text(),
        ]);

        $this->addForeignKey('fk-users_info-id_org','users_info','id_org','organizations','id','CASCADE','CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%users_info}}');
    }
}
