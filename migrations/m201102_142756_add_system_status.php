<?php

use yii\db\Migration;

/**
 * Class m201102_142756_add_system_status
 */
class m201102_142756_add_system_status extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\app\models\Founders::tableName(),'system_status',$this->boolean()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201102_142756_add_system_status cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201102_142756_add_system_status cannot be reverted.\n";

        return false;
    }
    */
}
