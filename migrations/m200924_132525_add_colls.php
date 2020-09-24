<?php

use yii\db\Migration;

/**
 * Class m200924_132525_add_colls
 */
class m200924_132525_add_colls extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\app\models\Objects::tableName(), 'pandus', $this->integer());
        $this->addColumn(\app\models\Objects::tableName(), 'mech_por', $this->integer());
        $this->addColumn(\app\models\Objects::tableName(), 'sanusel', $this->integer());
        $this->addColumn(\app\models\Objects::tableName(), 'signal', $this->integer());
        $this->addColumn(\app\models\Objects::tableName(), 'pokr', $this->integer());
        $this->addColumn(\app\models\Objects::tableName(), 'vives', $this->integer());
        $this->addColumn(\app\models\Objects::tableName(), 'min_per', $this->integer());
        $this->addColumn(\app\models\Objects::tableName(), 'max_per', $this->integer());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200924_132525_add_colls cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200924_132525_add_colls cannot be reverted.\n";

        return false;
    }
    */
}
