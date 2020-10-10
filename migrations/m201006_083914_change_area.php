<?php

use yii\db\Migration;

/**
 * Class m201006_083914_change_area
 */
class m201006_083914_change_area extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('org_area','m2_spo',$this->integer());
        $this->alterColumn('org_area','m2_bak',$this->integer());
        $this->alterColumn('org_area','m2_spec',$this->integer());
        $this->alterColumn('org_area','m2_mag',$this->integer());
        $this->alterColumn('org_area','m2_asp',$this->integer());
        $this->alterColumn('org_area','m2_ord',$this->integer());
        $this->alterColumn('org_area','m2_in',$this->integer());

        $this->alterColumn('org_area','c6m2_spo',$this->integer());
        $this->alterColumn('org_area','c6m2_bak',$this->integer());
        $this->alterColumn('org_area','c6m2_spec',$this->integer());
        $this->alterColumn('org_area','c6m2_mag',$this->integer());
        $this->alterColumn('org_area','c6m2_asp',$this->integer());
        $this->alterColumn('org_area','c6m2_ord',$this->integer());
        $this->alterColumn('org_area','c6m2_in',$this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201006_083914_change_area cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201006_083914_change_area cannot be reverted.\n";

        return false;
    }
    */
}
