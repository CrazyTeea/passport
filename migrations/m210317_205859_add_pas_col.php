<?php

use yii\db\Migration;

/**
 * Class m210317_205859_add_pas_col
 */
class m210317_205859_add_pas_col extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\app\models\Objects::tableName(),'year_cen',$this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210317_205859_add_pas_col cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210317_205859_add_pas_col cannot be reverted.\n";

        return false;
    }
    */
}
