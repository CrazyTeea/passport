<?php

use yii\db\Migration;

/**
 * Class m210309_202452_alter_col
 */
class m210309_202452_alter_col extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('objects','id_region',$this->integer()->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210309_202452_alter_col cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210309_202452_alter_col cannot be reverted.\n";

        return false;
    }
    */
}
