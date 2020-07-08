<?php

use yii\db\Migration;

/**
 * Class m200708_070438_add_colls_stud
 */
class m200708_070438_add_colls_stud extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\app\models\OrgLivingStudents::tableName(),'invalid',$this->boolean()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200708_070438_add_colls_stud cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200708_070438_add_colls_stud cannot be reverted.\n";

        return false;
    }
    */
}
