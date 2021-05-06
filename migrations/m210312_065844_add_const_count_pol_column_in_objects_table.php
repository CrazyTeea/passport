<?php

use yii\db\Migration;

/**
 * Class m210312_065844_add_const_count_pol_column_in_objects_table
 */
class m210312_065844_add_const_count_pol_column_in_objects_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('objects', 'const_count_pol', $this->integer()->defaultValue(7));

        $sql = "UPDATE objects 
                SET const_count_pol = count_pol
                WHERE id_org NOT IN (117, 181);";
        $this->execute($sql);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('objects', 'const_count_pol');
    }
}