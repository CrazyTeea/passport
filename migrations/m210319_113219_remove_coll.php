<?php

use yii\db\Migration;

/**
 * Class m210319_113219_remove_coll
 */
class m210319_113219_remove_coll extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn(\app\models\Objects::tableName(),'tech');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210319_113219_remove_coll cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210319_113219_remove_coll cannot be reverted.\n";

        return false;
    }
    */
}
