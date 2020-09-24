<?php

use yii\db\Migration;

/**
 * Class m200923_144142_add_real_estate
 */
class m200923_144142_add_real_estate extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\app\models\Objects::tableName(),'id_realEstate',$this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200923_144142_add_real_estate cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200923_144142_add_real_estate cannot be reverted.\n";

        return false;
    }
    */
}
