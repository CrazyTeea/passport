<?php

use yii\db\Migration;

/**
 * Class m201106_080907_remove_columns
 */
class m201106_080907_remove_columns extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn(\app\models\OrgArea::tableName(),'area_prig_prozh');
        $this->dropColumn(\app\models\OrgArea::tableName(),'area_zhil_prig_prozh');
        $this->dropColumn(\app\models\OrgArea::tableName(),'area_zan_obuch');
        $this->dropColumn(\app\models\OrgArea::tableName(),'area_in_kat_nan');
        $this->dropColumn(\app\models\OrgArea::tableName(),'svobod');
        $this->dropColumn(\app\models\OrgArea::tableName(),'ne_isp');
        $this->dropColumn(\app\models\OrgArea::tableName(),'ne_zhil_plosh_v_prig_dlya_prozh');
        $this->dropColumn(\app\models\OrgArea::tableName(),'area_obsh_ne_prig_dlya_prozh');
        $this->dropColumn(\app\models\OrgArea::tableName(),'area_kv_metr_zhil');
        $this->dropColumn(\app\models\OrgArea::tableName(),'area_kv_metr_obsh');
        $this->dropColumn(\app\models\OrgArea::tableName(),'area_obj_ne_isp_v_ust_dey');
        $this->dropColumn(\app\models\OrgArea::tableName(),'area_cnt_mest');
        $this->dropColumn(\app\models\OrgArea::tableName(),'area_cnt_mest_prig_prozh');
        $this->dropColumn(\app\models\OrgArea::tableName(),'area_cnt_mest_zan_obuch');
        $this->dropColumn(\app\models\OrgArea::tableName(),'area_cnt_mest_zan_in_obuch');
        $this->dropColumn(\app\models\OrgArea::tableName(),'area_cnt_svob_mest');
        $this->dropColumn(\app\models\OrgArea::tableName(),'area_cnt_ne_mest');
        $this->dropColumn(\app\models\OrgArea::tableName(),'area_cnt_mest_ne_prig_k_prozh');
        $this->dropColumn(\app\models\OrgArea::tableName(),'area_cnt_mest_invalid');
        $this->dropColumn(\app\models\OrgArea::tableName(),'area_cnt_mest_vozm_k_vvodu_v_esk');
        $this->dropColumn(\app\models\OrgArea::tableName(),'area_cnt_mest_vozm_mest_is_neisp');
        $this->dropColumn(\app\models\OrgArea::tableName(),'area_cnt_mest_vozm_mest_is_neprig');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201106_080907_remove_columns cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201106_080907_remove_columns cannot be reverted.\n";

        return false;
    }
    */
}
