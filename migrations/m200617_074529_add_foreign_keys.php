<?php

use yii\db\Migration;

/**
 * Class m200617_074529_add_foreign_keys
 */
class m200617_074529_add_foreign_keys extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey('fk-organizations-id_region','organizations','id_region','regions','id','CASCADE','CASCADE');
        $this->addForeignKey('fk-organizations-id_founder','organizations','id_founder','founders','id','CASCADE','CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200617_074529_add_foreign_keys cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200617_074529_add_foreign_keys cannot be reverted.\n";

        return false;
    }
    */
}
