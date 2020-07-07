<?php

use yii\db\Migration;

/**
 * Class m200707_072539_rename_colls
 */
class m200707_072539_rename_colls extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('org_area','6m2_spo','c6m2_spo');
        $this->renameColumn('org_area','6m2_bak','c6m2_bak');
        $this->renameColumn('org_area','6m2_spec','c6m2_spec');
        $this->renameColumn('org_area','6m2_mag','c6m2_mag');
        $this->renameColumn('org_area','6m2_asp','c6m2_asp');
        $this->renameColumn('org_area','6m2_ord','c6m2_ord');
        $this->renameColumn('org_area','6m2_in','c6m2_in');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200707_072539_rename_colls cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200707_072539_rename_colls cannot be reverted.\n";

        return false;
    }
    */
}
