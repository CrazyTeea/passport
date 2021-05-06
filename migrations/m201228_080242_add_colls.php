<?php

use yii\db\Migration;

/**
 * Class m201228_080242_add_colls
 */
class m201228_080242_add_colls extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('org_info','created_at',$this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'));
        $this->addColumn('org_info','updated_at',$this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201228_080242_add_colls cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201228_080242_add_colls cannot be reverted.\n";

        return false;
    }
    */
}
