<?php

use yii\db\Migration;

/**
 * Class m200710_131505_add_pom_dlya_kult
 */
class m200710_131505_add_pom_dlya_kult extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('objects_area','pom_dlya_kult',$this->decimal(22,3));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200710_131505_add_pom_dlya_kult cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200710_131505_add_pom_dlya_kult cannot be reverted.\n";

        return false;
    }
    */
}
