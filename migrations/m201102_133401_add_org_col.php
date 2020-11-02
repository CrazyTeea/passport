<?php

use yii\db\Migration;

/**
 * Class m201102_133401_add_org_col
 */
class m201102_133401_add_org_col extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\app\models\Organizations::tableName(),'active',$this->boolean()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201102_133401_add_org_col cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201102_133401_add_org_col cannot be reverted.\n";

        return false;
    }
    */
}
