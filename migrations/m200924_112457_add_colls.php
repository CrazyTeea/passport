<?php

use yii\db\Migration;

/**
 * Class m200924_112457_add_colls
 */
class m200924_112457_add_colls extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\app\models\Objects::tableName(),'date_start_reconstruct',$this->date());
        $this->addColumn(\app\models\Objects::tableName(),'date_end_reconstruct',$this->date());
        $this->addColumn(\app\models\Objects::tableName(),'rec_money_faip',$this->decimal(22,3));
        $this->addColumn(\app\models\Objects::tableName(),'rec_money_bud_sub',$this->decimal(22,3));
        $this->addColumn(\app\models\Objects::tableName(),'rec_money_vneb',$this->decimal(22,3));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200924_112457_add_colls cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200924_112457_add_colls cannot be reverted.\n";

        return false;
    }
    */
}
