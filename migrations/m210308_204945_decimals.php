<?php

use yii\db\Migration;

/**
 * Class m210308_204945_decimals
 */
class m210308_204945_decimals extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn(\app\models\Objects::tableName(), 'smet', $this->decimal(22, 2));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210308_204945_decimals cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210308_204945_decimals cannot be reverted.\n";

        return false;
    }
    */
}
