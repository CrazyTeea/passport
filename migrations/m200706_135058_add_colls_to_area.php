<?php

use yii\db\Migration;

/**
 * Class m200706_135058_add_colls_to_area
 */
class m200706_135058_add_colls_to_area extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('org_area','area_cnt_nuzhd_zhil',$this->integer());
        $this->addColumn('org_area','area_cnt_prozh_u_drugih',$this->integer());
        $this->addColumn('org_area','area_cnt_mest_vozm_k_vvodu_v_esk',$this->integer());
        $this->addColumn('org_area','area_cnt_mest_vozm_mest_is_neisp',$this->integer());
        $this->addColumn('org_area','area_cnt_mest_vozm_mest_is_neprig',$this->integer());

        $this->addForeignKey('fk-org_area-id_org','org_area','id_org','organizations','id','CASCADE','CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200706_135058_add_colls_to_area cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200706_135058_add_colls_to_area cannot be reverted.\n";

        return false;
    }
    */
}
