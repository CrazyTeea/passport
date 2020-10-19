<?php

use yii\db\Migration;

/**
 * Class m201013_120601_add_col
 */
class m201013_120601_add_col extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\app\models\Countries::tableName(), 'flag', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201013_120601_add_col cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201013_120601_add_col cannot be reverted.\n";

        return false;
    }
    */
}
