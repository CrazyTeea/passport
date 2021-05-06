<?php

use yii\db\Migration;

/**
 * Class m210311_080513_add_count_pol_column_in_objects_and_org_info_tables
 */
class m210311_080513_add_count_pol_column_in_objects_and_org_info_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('objects', 'count_pol', $this->integer()->defaultValue(0));
        $this->addColumn('organizations', 'count_pol', $this->integer()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('objects', 'count_pol');
        $this->dropColumn('organizations', 'count_pol');
    }
}