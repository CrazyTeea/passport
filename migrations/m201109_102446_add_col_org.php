<?php

use yii\db\Migration;

/**
 * Class m201109_102446_add_col_org
 */
class m201109_102446_add_col_org extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('organizations','data_complete',$this->boolean()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201109_102446_add_col_org cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201109_102446_add_col_org cannot be reverted.\n";

        return false;
    }
    */
}
