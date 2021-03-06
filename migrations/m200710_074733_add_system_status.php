<?php

use yii\db\Migration;

/**
 * Class m200710_074733_add_system_status
 */
class m200710_074733_add_system_status extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('objects','system_status',$this->boolean()->defaultValue(1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200710_074733_add_system_status cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200710_074733_add_system_status cannot be reverted.\n";

        return false;
    }
    */
}
