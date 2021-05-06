<?php

use yii\db\Migration;

/**
 * Class m210309_184954_add_colls
 */
class m210309_184954_add_colls extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('objects','wifi',$this->boolean()->defaultValue(0));
        $this->addColumn('objects','tech',$this->boolean()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210309_184954_add_colls cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210309_184954_add_colls cannot be reverted.\n";

        return false;
    }
    */
}
