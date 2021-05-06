<?php

use app\models\Objects;
use yii\db\Migration;

/**
 * Class m210310_083116_alter_columns
 */
class m210310_083116_alter_columns extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('objects', 'wifi', $this->boolean()->defaultValue(null));
        $this->alterColumn('objects', 'tech', $this->boolean()->defaultValue(null));

        Objects::updateAll(['wifi' => null, 'tech' => null], ['wifi' => 0, 'tech' => 0]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210310_083116_alter_columns cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210310_083116_alter_columns cannot be reverted.\n";

        return false;
    }
    */
}
