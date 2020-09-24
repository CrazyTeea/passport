<?php

use yii\db\Migration;

/**
 * Class m200924_124921_add_colls
 */
class m200924_124921_add_colls extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\app\models\Objects::tableName(), 'reason', $this->text());
        $this->addColumn(\app\models\Objects::tableName(), 'uslovie', $this->text());
        $this->addColumn(\app\models\Objects::tableName(), 'nevos_reason', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200924_124921_add_colls cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200924_124921_add_colls cannot be reverted.\n";

        return false;
    }
    */
}
