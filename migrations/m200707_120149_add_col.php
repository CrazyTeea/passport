<?php

use yii\db\Migration;

/**
 * Class m200707_120149_add_col
 */
class m200707_120149_add_col extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('org_living_students','budjet_type',$this->integer()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200707_120149_add_col cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200707_120149_add_col cannot be reverted.\n";

        return false;
    }
    */
}
