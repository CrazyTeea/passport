<?php

use yii\db\Migration;

/**
 * Class m210310_084126_update_objects_table
 */
class m210310_084126_update_objects_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('objects', 'wifi', $this->boolean()->defaultValue(null));
        $this->alterColumn('objects', 'tech', $this->boolean()->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('objects', 'wifi', $this->boolean()->defaultValue(0));
        $this->alterColumn('objects', 'tech', $this->boolean()->defaultValue(0));
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210310_084126_update_objects_table cannot be reverted.\n";

        return false;
    }
    */
}
