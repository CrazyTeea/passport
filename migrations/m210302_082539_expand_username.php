<?php

use yii\db\Migration;

/**
 * Class m210302_082539_expand_username
 */
class m210302_082539_expand_username extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('user','username',$this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210302_082539_expand_username cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210302_082539_expand_username cannot be reverted.\n";

        return false;
    }
    */
}
