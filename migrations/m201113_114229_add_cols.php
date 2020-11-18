<?php

use yii\db\Migration;

/**
 * Class m201113_114229_add_cols
 */
class m201113_114229_add_cols extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\app\models\ObjectsArea::tableName(),'cnt_mest_pl_na_odn',$this->decimal(22,3));
        $this->addColumn(\app\models\ObjectsArea::tableName(),'cnt_mest_obsh_na_odn',$this->decimal(22,3));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201113_114229_add_cols cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201113_114229_add_cols cannot be reverted.\n";

        return false;
    }
    */
}
