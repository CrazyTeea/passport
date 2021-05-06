<?php

use yii\db\Migration;

/**
 * Class m210317_144711_remove_colls
 */
class m210317_144711_remove_colls extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('org_area','m2_bak');
        $this->dropColumn('org_area','m2_spec');
        $this->dropColumn('org_area','m2_mag');
        $this->dropColumn('org_area','m2_asp');
        $this->dropColumn('org_area','m2_ord');
        $this->dropColumn('org_area','c6m2_bak');
        $this->dropColumn('org_area','c6m2_spec');
        $this->dropColumn('org_area','c6m2_mag');
        $this->dropColumn('org_area','c6m2_asp');
        $this->dropColumn('org_area','c6m2_ord');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210317_144711_remove_colls cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210317_144711_remove_colls cannot be reverted.\n";

        return false;
    }
    */
}
