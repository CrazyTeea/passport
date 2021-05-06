<?php

use yii\db\Migration;

/**
 * Class m201230_064510_add_column
 */
class m201230_064510_add_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('objects', 'created_at', $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'));
        $this->addColumn('objects', 'updated_at', $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201230_064510_add_column cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201230_064510_add_column cannot be reverted.\n";

        return false;
    }
    */
}
