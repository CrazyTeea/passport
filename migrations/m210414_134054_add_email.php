<?php

use yii\db\Migration;

/**
 * Class m210414_134054_add_email
 */
class m210414_134054_add_email extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\app\models\User::tableName(),'email',$this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210414_134054_add_email cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210414_134054_add_email cannot be reverted.\n";

        return false;
    }
    */
}
