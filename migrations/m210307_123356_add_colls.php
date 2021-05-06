<?php

use yii\db\Migration;

/**
 * Class m210307_123356_add_colls
 */
class m210307_123356_add_colls extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\app\models\OrgArea::tableName(),'c6m2_vis',$this->integer());
        $this->addColumn(\app\models\OrgArea::tableName(),'m2_vis',$this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210307_123356_add_colls cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210307_123356_add_colls cannot be reverted.\n";

        return false;
    }
    */
}
