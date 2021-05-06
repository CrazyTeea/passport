<?php

use yii\db\Migration;

/**
 * Class m210308_203204_decimals
 */
class m210308_203204_decimals extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn(\app\models\Objects::tableName(), 'money_faip', $this->decimal(22, 2));
        $this->alterColumn(\app\models\Objects::tableName(), 'money_bud_sub', $this->decimal(22, 2));
        $this->alterColumn(\app\models\Objects::tableName(), 'money_vneb', $this->decimal(22, 2));
        $this->alterColumn(\app\models\Objects::tableName(), 'rec_money_faip', $this->decimal(22, 2));
        $this->alterColumn(\app\models\Objects::tableName(), 'rec_money_bud_sub', $this->decimal(22, 2));
        $this->alterColumn(\app\models\Objects::tableName(), 'rec_money_vneb', $this->decimal(22, 2));

        $cols = \app\models\ObjectsMoney::getTableSchema()->getColumnNames();

        foreach ($cols as $col) {
            if (in_array($col, ['id', 'id_object']))
                continue;
            $this->alterColumn(\app\models\ObjectsMoney::tableName(), $col, $this->decimal(22, 2));
        }

        $cols = \app\models\ObjectsTariff::getTableSchema()->getColumnNames();

        foreach ($cols as $col) {
            if (in_array($col, ['id', 'id_object']))
                continue;
            $this->alterColumn(\app\models\ObjectsTariff::tableName(), $col, $this->decimal(22, 2));
        }

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210308_203204_decimals cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210308_203204_decimals cannot be reverted.\n";

        return false;
    }
    */
}
