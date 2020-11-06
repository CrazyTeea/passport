<?php

use yii\db\Migration;

/**
 * Class m201105_144812_remove_columns
 */
class m201105_144812_remove_columns extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn(\app\models\OrgArea::tableName(),'area_zhil_t_k_r');
        $this->dropColumn(\app\models\OrgArea::tableName(),'area_zhil_n_a_s');
        $this->dropColumn(\app\models\OrgArea::tableName(),'area_zhil_n_p');
        $this->dropColumn(\app\models\OrgArea::tableName(),'area_ne_zhil_t_k_r');
        $this->dropColumn(\app\models\OrgArea::tableName(),'area_ne_zhil_n_a_s');
        $this->dropColumn(\app\models\OrgArea::tableName(),'area_ne_zhil_n_p');
        $this->dropColumn(\app\models\OrgArea::tableName(),'area_obsh_t_k_r');
        $this->dropColumn(\app\models\OrgArea::tableName(),'area_obsh_zhil_n_a_s');
        $this->dropColumn(\app\models\OrgArea::tableName(),'area_obsh_zhil_n_p');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201105_144812_remove_columns cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201105_144812_remove_columns cannot be reverted.\n";

        return false;
    }
    */
}
